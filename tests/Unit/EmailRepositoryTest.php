<?php

namespace Tests\Unit;

use App\Exceptions\EmailRepositoryException;
use App\Models\Email;
use App\Repository\EmailRepository;
use App\Repository\EmailRepositoryContract;
use Illuminate\Support\Str;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Tests\TestCase;
use Tests\Traits\EmailStorageTestHelper;

class EmailRepositoryTest extends TestCase
{
    use EmailStorageTestHelper;

    protected EmailRepository $repository;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->app->get(EmailRepositoryContract::class);
    }

    /**
     * @return void
     */
    public function test_it_can_find_an_email_by_id()
    {
        $email = Email::factory()->create();

        $this->assertNotNull($emailRecord = $this->repository->findById($email->id));
        $this->assertInstanceOf(Email::class, $emailRecord);
    }

    /**
     * @return void
     */
    public function test_it_can_check_if_email_signature_already_exists()
    {
        $email = Email::factory()->create();

        $this->assertTrue($this->repository->signatureExists($email->signature));
        $this->assertFalse($this->repository->signatureExists(md5('test')));
    }

    /**
     * @return void
     */
    public function test_it_can_get_all_emails()
    {
        $expectedFirstBatchCount = 25;
        $expectedSecondBatchCount = 5;

        Email::factory()->count($expectedFirstBatchCount + $expectedSecondBatchCount)->create();

        $firstBatchEmails = $this->repository->getAll($expectedFirstBatchCount);
        $this->assertCount($expectedFirstBatchCount, $firstBatchEmails);

        $secondBatchEmails = $this->repository->getAll($expectedSecondBatchCount, $expectedFirstBatchCount);
        $this->assertCount($expectedSecondBatchCount, $secondBatchEmails);

        $emails = $firstBatchEmails->merge($secondBatchEmails);
        $this->assertContainsOnlyInstancesOf(Email::class, $emails);
    }

    /**
     * @throws EmailRepositoryException
     */
    public function test_it_can_store_email()
    {
        $path = Str::remove('/var/www/storage/app', $this->getTestFilePath());

        $email = $this->repository->storeEmail(
            $path,
            $this->getTestFileSignature()
        );

        $this->assertInstanceOf(Email::class, $email);

        $this->assertDatabaseHas('emails', [
            'signature' => $this->getTestFileSignature(),
        ]);
    }
}
