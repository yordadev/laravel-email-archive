<?php

namespace App\Repository;

interface BodyRepositoryContract
{
    public function store(int $emailId, string $message): void;
}
