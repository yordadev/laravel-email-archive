<?php

namespace App\Repository;

use App\Models\EmailBody;

class BodyRepository implements BodyRepositoryContract
{
    public function store(int $emailId, string $message): void
    {
        EmailBody::create([
            'email_id' => $emailId,
            'content' => $message,
            'signature' => md5($message),
        ]);
    }
}
