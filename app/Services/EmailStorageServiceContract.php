<?php

namespace App\Services;

use App\Models\Email;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;

interface EmailStorageServiceContract
{
    public function store(UploadedFile $emailFile): Email;

    public function find(int $id): ?Email;

    public function all(int $limit, int $offset, string $sortDirection): Collection;

    public function getEmailCount(): int;

    public function extractEmailFrom(string $text): string;

    public function delete(int $id): bool;

    public function emailSearch(string $search, int $limit, string $sortDirection): LengthAwarePaginator;

    public function headerSearch(int $emailId, string $search, int $limit, string $sortDirection): LengthAwarePaginator;
}
