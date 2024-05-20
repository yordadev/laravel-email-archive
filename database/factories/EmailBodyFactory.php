<?php

namespace Database\Factories;

use App\Models\Email;
use App\Models\EmailBody;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EmailBody>
 */
class EmailBodyFactory extends AbstractEmailBaseFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     *
     * @throws Exception
     */
    public function definition(): array
    {
        return [
            'email_id' => Email::factory(),
            'content' => $messageBody = ($this->getEmailParser())->getMessageBody(),
            'signature' => md5($messageBody),
        ];
    }

    public function withContent(string $content): self
    {
        return $this->state(function () use ($content) {
            return [
                'content' => $content,
                'signature' => md5($content),
            ];
        });
    }
}
