<?php

namespace Database\Factories;

use App\Models\Email;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use PhpMimeMailParser\Parser;

abstract class AbstractEmailBaseFactory extends Factory
{
    const string EMAIL_DIRECTORY = 'emails';

    const string SEEDED_TEST_EMAIL_PATH = 'host-with-us_-hacker-x--a-i-san-francisco–-a-premier-a-i-event!.eml';

    /**
     * @throws Exception
     */
    private function getDemoEmailPath(): string
    {
        $file = Storage::path(self::EMAIL_DIRECTORY.'/'.self::SEEDED_TEST_EMAIL_PATH);

        if (empty($file)) {
            throw new Exception('No test .eml file found in storage/app/emails; run the seeder.');
        }

        return $file;
    }

    /**
     * @throws Exception
     */
    public function getEmailParser(): Parser
    {
        return (new Parser())->setPath($this->getDemoEmailPath());
    }

    public function withEmail(Email $email): self
    {
        return $this->state(function () use ($email) {
            return [
                'email_id' => $email->id,
            ];
        });
    }
}
