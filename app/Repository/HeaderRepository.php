<?php

namespace App\Repository;

use App\Models\EmailHeader;
use Illuminate\Pagination\LengthAwarePaginator;

class HeaderRepository implements HeaderRepositoryContract
{
    public function search(int $emailId, string $search, int $limit, string $sortDirection): LengthAwarePaginator
    {
        return EmailHeader::query()
            ->where('email_id', $emailId)
            ->search($search)
            ->orderBy('key', $sortDirection)
            ->paginate($limit);
    }

    public function store(int $emailId, array $headers): void
    {
        collect($headers)->each(function ($value, $key) use ($emailId) {
            EmailHeader::create([
                'email_id' => $emailId,
                'key' => $key,
                'value' => is_array($value) ? json_encode($value) : $value,
            ]);
        });
    }
}
