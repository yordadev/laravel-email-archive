<?php

namespace Database\Factories;

use App\Models\Email;
use App\Models\EmailHeader;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EmailHeader>
 */
class EmailHeaderFactory extends AbstractEmailBaseFactory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email_id' => Email::factory(),
            'key' => $this->faker->word(),
            'value' => $this->faker->userAgent(),
        ];
    }

    public function withHeader(string $key, array|string $value): self
    {
        if (is_array($value)) {
            $value = implode(',', $value);
        }

        return $this->state(function () use ($key, $value) {
            return [
                'key' => $key,
                'value' => $value,
            ];
        });
    }
}
