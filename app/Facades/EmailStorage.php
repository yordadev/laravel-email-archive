<?php

namespace App\Facades;

use App\Models\Email;
use App\Repository\EmailRepository;
use App\Services\EmailStorageService;
use App\Services\EmailStorageServiceContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Email store(UploadedFile $emailFile)
 * @method static Email find(int $id, array $withRelations = [])
 * @method static int getEmailCount()
 * @method static string extractEmailFrom(string $text)
 * @method static Collection all(int $limit, int $offset, string $sortBy, array $withRelations)
 * @method static void delete(string $id)
 * @method static LengthAwarePaginator emailSearch(string $search, int $limit, string $sortDirection)
 * @method static LengthAwarePaginator headerSearch(int $emailId, string $search, int $limit, string $sortDirection)
 */
class EmailStorage extends Facade
{
    const int DEFAULT_LIMIT = EmailRepository::DEFAULT_LIMIT;

    const int DEFAULT_OFFSET = EmailStorageService::DEFAULT_OFFSET;

    const string DEFAULT_SORT_BY = EmailStorageService::DEFAULT_SORT_BY;

    const array DEFAULT_WITH_RELATIONS = EmailStorageService::DEFAULT_WITH;

    const array AVAILABLE_RELATIONS = EmailStorageService::AVAILABLE_RELATIONS;

    const string UPLOADED_EMAIL_PATH = 'uploaded-emails';

    protected static function getFacadeAccessor(): string
    {
        return EmailStorageServiceContract::class;
    }
}
