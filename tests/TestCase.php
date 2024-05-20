<?php

namespace Tests;

use App\Facades\EmailStorage;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Storage;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions;

    protected function tearDown(): void
    {
        foreach (Storage::files(EmailStorage::UPLOADED_EMAIL_PATH) as $key => $fileName) {
            Storage::delete($fileName);
        }

        Storage::deleteDirectory(EmailStorage::UPLOADED_EMAIL_PATH);

        parent::tearDown();
    }
}
