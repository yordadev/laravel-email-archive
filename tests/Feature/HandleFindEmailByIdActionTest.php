<?php

namespace Tests\Feature;

use App\Facades\EmailStorage;
use App\Models\Email;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;
use Tests\Traits\EmailStorageTestHelper;

class HandleFindEmailByIdActionTest extends TestCase
{
    use EmailStorageTestHelper, RefreshDatabase;

    protected string $route;

    protected Email $email;

    public function test_it_can_locate_email_with_all_available_relations(): void
    {
        $response = $this->getRequest(id: $this->email->id, withRelations: EmailStorage::AVAILABLE_RELATIONS);

        $payload = $response->getOriginalContent();
        $response->assertStatus(200);

        $this->assertArrayHasKey('result', $payload);
        $this->assertArrayHasKey('detail', $payload['result']);
        $this->assertArrayHasKey('body', $payload['result']);
        $this->assertArrayHasKey('headers', $payload['result']);
    }

    public function test_it_can_locate_email_with_default_detail(): void
    {
        $response = $this->getRequest(id: $this->email->id);

        $payload = $response->getOriginalContent();
        $response->assertStatus(200);

        $this->assertArrayHasKey('result', $payload);

        $this->assertArrayHasKey('detail', $payload['result']);

        $this->assertArrayNotHasKey('body', $payload['result']);
        $this->assertArrayNotHasKey('headers', $payload['result']);
    }

    public function test_it_cannot_locate_email_validation_failure(): void
    {
        $response = $this->getRequest(id: $this->email->id, withRelations: [
            'invalid-relation',
        ]);

        $response->assertStatus(422);
    }

    private function getRequest(
        int $id,
        array $withRelations = []
    ): TestResponse {
        $routeWithQuery = $this->route."?id={$id}";

        if (! empty($withRelations)) {
            $withRelationsQuery = http_build_query(['with_relations' => $withRelations]);
            $routeWithQuery .= "&{$withRelationsQuery}";
        }

        return $this->get($routeWithQuery, [
            'accept' => 'application/json',
            'content-type' => 'application/x-www-form-urlencoded',
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->route = route('get.email.find');
        $this->withoutMiddleware();

        $this->email = Email::factory()->create();
    }
}
