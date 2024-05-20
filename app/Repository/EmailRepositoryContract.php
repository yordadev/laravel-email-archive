<?php

namespace App\Repository;

use App\Models\Email;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface EmailRepositoryContract
{
    public function getAll(int $limit, int $offset, string $sortBy, array $with): Collection;

    public function signatureExists(string $emailMD5Signature): bool;

    public function findById(int $id, array $with): ?Email;

    public function storeEmail(string $tempLocalPath, string $emailSignature): Email;

    public function count(): int;

    public function extractEmailAddress($text): string;

    public function deleteEmail(Email $email): bool;

    public function search(string $search, int $limit): LengthAwarePaginator;
}
