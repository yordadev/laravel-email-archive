<?php

namespace Tests\Integration;

use App\Exceptions\EmailRepositoryException;
use App\Models\Email;
use App\Services\EmailStorageService;
use App\Services\EmailStorageServiceContract;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Tests\TestCase;
use Tests\Traits\EmailStorageTestHelper;

class EmailStorageServiceTest extends TestCase
{
    use EmailStorageTestHelper;

    protected EmailStorageService $emailStorageService;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->emailStorageService = $this->app->get(EmailStorageServiceContract::class);
    }

    /**
     * @return void
     *
     * @throws EmailRepositoryException
     */
    public function test_it_can_store_a_provided_email()
    {
        $uploadedFile = $this->getFakeTestFile();
        $email = $this->emailStorageService->store($uploadedFile);

        $this->assertInstanceOf(Email::class, $email);

        $this->assertEquals($email->signature, $this->getTestFileSignature());

        $this->assertDatabaseHas('email_details', [
            'email_id' => $email->id,
        ]);

        $this->assertDatabaseHas('email_headers', [
            'email_id' => $email->id,
        ]);

        $this->assertDatabaseHas('email_bodies', [
            'email_id' => $email->id,
        ]);
    }

    /**
     * @return void
     */
    public function test_it_can_find_an_existing_email_by_id()
    {
        $email = Email::factory()->create();
        $record = $this->emailStorageService->find($email->id);

        $this->assertEquals($email->id, $record->id);
        $this->assertInstanceOf(Email::class, $record);
    }

    /**
     * @return void
     */
    public function test_it_cannot_find_an_existing_email_by_id_throws_exception()
    {
        $this->assertNull($this->emailStorageService->find(rand(999, 99999)));
    }
}
