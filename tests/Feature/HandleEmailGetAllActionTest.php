<?php

namespace Tests\Feature;

use App\Facades\EmailStorage;
use App\Models\Email;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;
use Tests\Traits\EmailStorageTestHelper;

class HandleEmailGetAllActionTest extends TestCase
{
    use EmailStorageTestHelper, RefreshDatabase;

    protected string $route;

    protected int $expectedFirstBatchCount;

    protected int $expectedSecondBatchCount;

    public function test_get_all_action_returns_default_limit_emails(): void
    {
        $response = $this->getRequest();

        $payload = $response->getOriginalContent();
        $response->assertStatus(200);

        $this->assertCount($this->expectedFirstBatchCount, $payload['result']);
    }

    public function test_get_all_action_returns_offset_limit_page_2_emails(): void
    {
        $response = $this->getRequest(offset: $this->expectedFirstBatchCount);

        $payload = $response->getOriginalContent();
        $response->assertStatus(200);

        $this->assertCount($this->expectedSecondBatchCount, $payload['result']);
    }

    private function getRequest(
        int $limit = EmailStorage::DEFAULT_LIMIT,
        int $offset = EmailStorage::DEFAULT_OFFSET,
        string $sortBy = EmailStorage::DEFAULT_SORT_BY
    ): TestResponse {
        return $this->get($this->route."?limit={$limit}&offset={$offset}&sort_by={$sortBy}", [
            'accept' => 'application/json',
            'content-type' => 'multipart/form-data',
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->route = route('get.email.all');
        $this->withoutMiddleware();

        $this->expectedFirstBatchCount = 25;
        $this->expectedSecondBatchCount = 5;

        Email::factory()->count($this->expectedFirstBatchCount + $this->expectedSecondBatchCount)->create();
    }
}
