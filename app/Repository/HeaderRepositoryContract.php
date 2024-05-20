<?php

namespace App\Repository;

use Illuminate\Pagination\LengthAwarePaginator;

interface HeaderRepositoryContract
{
    public function search(int $emailId, string $search, int $limit, string $sortDirection): LengthAwarePaginator;

    public function store(int $emailId, array $headers): void;
}
