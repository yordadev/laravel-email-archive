<?php

namespace App\Services;

use App\Exceptions\EmailRepositoryException;
use App\Exceptions\EmailStorageServiceException;
use App\Models\Email;
use App\Repository\EmailRepository;
use App\Repository\HeaderRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class EmailStorageService implements EmailStorageServiceContract
{
    const int DEFAULT_LIMIT = EmailRepository::DEFAULT_LIMIT;

    const int DEFAULT_OFFSET = EmailRepository::DEFAULT_OFFSET;

    const string DEFAULT_SORT_BY = EmailRepository::DEFAULT_SORT_BY;

    const array DEFAULT_WITH = EmailRepository::DEFAULT_WITH;

    const array AVAILABLE_RELATIONS = EmailRepository::AVAILABLE_WITH;

    const string EMAIL_STORAGE_FOLDER = 'uploaded-emails';

    public function __construct(
        protected EmailRepository $emailRepository,
        protected HeaderRepository $headerRepository
    ) {
        //
    }

    /**
     * @throws EmailRepositoryException
     */
    public function store(UploadedFile $emailFile): Email
    {
        $tempLocalPath = Storage::putFileAs(self::EMAIL_STORAGE_FOLDER, $emailFile, $emailFile->getClientOriginalName());

        return $this->emailRepository->storeEmail(
            $tempLocalPath,
            $this->generateEmailSignature($tempLocalPath)
        );
    }

    public function generateEmailSignature($tempLocalPath): string
    {
        return md5(Storage::get($tempLocalPath));
    }

    public function find(int $id, array $with = self::DEFAULT_WITH): ?Email
    {
        return $this->emailRepository->findById($id, $with);
    }

    public function all(
        int $limit = self::DEFAULT_LIMIT,
        int $offset = self::DEFAULT_OFFSET,
        string $sortDirection = self::DEFAULT_SORT_BY,
        array $with = self::DEFAULT_WITH
    ): Collection {
        return $this->emailRepository->getAll($limit, $offset, $sortDirection, $with);
    }

    public function getEmailCount(): int
    {
        return $this->emailRepository->count();
    }

    public function extractEmailFrom(string $text): string
    {
        return $this->emailRepository->extractEmailAddress($text);
    }

    public function delete(int $id): bool
    {
        $email = $this->emailRepository->findById($id);

        return $this->emailRepository->deleteEmail($email);
    }

    /**
     * @throws EmailStorageServiceException
     */
    public function emailSearch(string $search, int $limit, string $sortDirection): LengthAwarePaginator
    {
        $this->validateSortDirection($sortDirection);

        return $this->emailRepository->search($search, $limit, $sortDirection);
    }

    /**
     * @throws EmailStorageServiceException
     */
    public function headerSearch(int $emailId, string $search, int $limit, string $sortDirection): LengthAwarePaginator
    {
        $this->validateSortDirection($sortDirection);

        return $this->headerRepository->search($emailId, $search, $limit, $sortDirection);
    }

    /**
     * @throws EmailStorageServiceException
     */
    private function validateSortDirection(string $sortDirection): void
    {
        in_array($sortDirection, ['asc', 'desc'])
            ?: throw new EmailStorageServiceException('Invalid sort direction');
    }
}
