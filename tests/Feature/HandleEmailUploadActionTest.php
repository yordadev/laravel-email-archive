<?php

namespace Tests\Feature;

use Illuminate\Testing\TestResponse;
use Tests\TestCase;
use Tests\Traits\EmailStorageTestHelper;

class HandleEmailUploadActionTest extends TestCase
{
    use EmailStorageTestHelper;

    protected string $route;

    public function test_the_action_returns_a_successful_response(): void
    {
        $response = $this->postRequest([
            'file' => $this->getFakeTestFile(),
        ]);

        $payload = $response->getOriginalContent();
        $response->assertStatus(201);

        $this->assertArrayHasKey('result', $payload);

        $email = $payload['result'];

        $this->assertArrayHasKey('id', $email);
        $this->assertArrayHasKey('signature', $email);
        $this->assertArrayHasKey('has_attachments', $email);
        $this->assertArrayHasKey('detail', $email);

        $emailDetail = $email['detail'];
        $this->assertArrayHasKey('from', $emailDetail);
        $this->assertArrayHasKey('to', $emailDetail);
        $this->assertArrayHasKey('subject', $emailDetail);
        $this->assertArrayHasKey('message_id', $emailDetail);
    }

    public function test_the_action_returns_validation_error_response(): void
    {
        $response = $this->postRequest([
            'file' => $this->getFakeBadTestFile(),
        ]);

        $payload = $response->getOriginalContent();
        $response->assertStatus(422);

        $this->assertEquals('The file field must be a file of type: eml.', $payload['message']);
        $this->assertArrayHasKey('errors', $payload);
        $this->assertArrayHasKey('file', $payload['errors']);
    }

    private function postRequest($payload): TestResponse
    {
        return $this->post($this->route, $payload, [
            'accept' => 'application/json',
            'content-type' => 'multipart/form-data',
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->route = route('post.email.upload');
    }
}
