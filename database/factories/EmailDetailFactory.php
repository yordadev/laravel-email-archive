<?php

namespace Database\Factories;

use App\Models\Email;
use App\Models\EmailDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EmailDetail>
 */
class EmailDetailFactory extends AbstractEmailBaseFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     *
     * @throws \Exception
     */
    public function definition(): array
    {
        return [
            'email_id' => Email::factory(),
            'from' => $this->faker->email,
            'to' => $this->faker->email,
            'subject' => $this->faker->sentence,
            'message_id' => $this->getEmailParser()->getHeader('message-id'),
        ];
    }

    public function withFrom(string $from): self
    {
        return $this->state(function () use ($from) {
            return [
                'from' => $from,
            ];
        });
    }

    public function withTo(string $to): self
    {
        return $this->state(function () use ($to) {
            return [
                'to' => $to,
            ];
        });
    }

    public function withSubject(string $subject): self
    {
        return $this->state(function () use ($subject) {
            return [
                'subject' => $subject,
            ];
        });
    }

    public function withMessageID(string $id): self
    {
        return $this->state(function () use ($id) {
            return [
                'message_id' => $id,
            ];
        });
    }
}
