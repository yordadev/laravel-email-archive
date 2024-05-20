<?php

namespace App\Repository;

use App\Exceptions\EmailRepositoryException;
use App\Jobs\ProcessImportedEmailJob;
use App\Models\Email;
use App\Models\EmailDetail;
use App\Models\EmailHeader;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpMimeMailParser\Parser;

class EmailRepository implements EmailRepositoryContract
{
    const int DEFAULT_LIMIT = 25;

    const int DEFAULT_OFFSET = 0;

    const string DEFAULT_SORT_BY = 'desc';

    const array DEFAULT_WITH = [
        'detail',
    ];

    const array AVAILABLE_WITH = [
        'detail',
        'headers',
        'body',
    ];

    public function getAll(int $limit = self::DEFAULT_LIMIT, int $offset = self::DEFAULT_OFFSET, string $sortBy = self::DEFAULT_SORT_BY, array $with = self::DEFAULT_WITH): Collection
    {
        return Email::orderBy('id', $sortBy)
            ->skip($offset)
            ->take($limit)
            ->with($with)
            ->get();
    }

    public function signatureExists(string $emailMD5Signature): bool
    {
        return Email::query()
            ->where('signature', $emailMD5Signature)
            ->exists();
    }

    public function findById(int $id, array $with = self::DEFAULT_WITH): ?Email
    {
        $with = array_filter($with, function ($value) {
            return in_array($value, self::AVAILABLE_WITH);
        });

        return Email::where('id', $id)->with($with)->first();
    }

    /**
     * @throws EmailRepositoryException
     */
    public function storeEmail(string $tempLocalPath, string $emailSignature): Email
    {
        DB::beginTransaction();

        $tempLocalFile = Storage::get($tempLocalPath);

        if (! $tempLocalFile) {
            throw new EmailRepositoryException($tempLocalFile.' not found');
        }
        $emailParser = (new Parser())->setText($tempLocalFile);

        try {
            $email = $this->createEmailRecord($emailSignature, $emailParser);

            $this->createEmailDetailRecord($email->id, $emailParser);

            ProcessImportedEmailJob::dispatch($email->id, $tempLocalPath);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new EmailRepositoryException($exception->getMessage(), $exception);
        }

        return $this->findById($email->id);
    }

    private function createEmailDetailRecord(int $emailId, Parser $parser): void
    {
        EmailDetail::create([
            'email_id' => $emailId,
            'from' => $this->extractEmailAddress($parser->getHeader('from')),
            'to' => $this->extractEmailAddress($parser->getHeader('to')),
            'subject' => $parser->getHeader('subject'),
            'message_id' => $parser->getHeader('message-id'),
        ]);
    }

    public function extractEmailAddress($text): string
    {
        // Improved regex pattern for matching email addresses
        $regex = '/\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,}\b/';

        // Perform the regex match
        preg_match($regex, $text, $matches);

        return empty($matches) ? '' : $matches[0];
    }

    private function createEmailRecord(string $emailSignature, Parser $parser): Email
    {
        return Email::create([
            'signature' => $emailSignature,
            'has_attachments' => ! empty($parser->getAttachments()),
        ]);
    }

    public function count(): int
    {
        return Email::count();
    }

    public function deleteEmail(Email $email): bool
    {
        $email->body()->delete();
        $email->detail()->delete();
        $email->headers()->each(function (EmailHeader $emailHeader) {
            $emailHeader->delete();
        });

        return $email->delete();
    }

    public function search(string $search, int $limit = self::DEFAULT_LIMIT, string $sortDirection = self::DEFAULT_SORT_BY): LengthAwarePaginator
    {
        $query = Email::query();

        if (! empty($search)) {
            $query->search($search);
        }

        return $query->orderBy('created_at', $sortDirection)->paginate($limit);
    }
}
