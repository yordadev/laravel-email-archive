<?php

namespace Database\Factories;

use App\Facades\EmailStorage;
use App\Models\Email;
use App\Models\EmailBody;
use App\Models\EmailDetail;
use App\Models\EmailHeader;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use PhpMimeMailParser\Parser;

/**
 * @extends Factory<Email>
 */
class EmailFactory extends AbstractEmailBaseFactory
{
    protected $model = Email::class;

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
            'signature' => md5(($parser = $this->getEmailParser())->getData()),
            'has_attachments' => ! empty($parser->getAttachments()),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @throws Exception
     */
    public function configure(): static
    {
        $parser = $this->getEmailParser();

        return $this->afterMaking(function (Email $email) use ($parser) {
            collect($parser->getHeaders())->each(function ($value, $key) use ($email) {
                $this->buildEmailHeaderFactory($email, $key, $value)->make();
            });

            $this->buildEmailBodyFactory($email, $parser)->make();

            $this->buildEmailDetailFactory($email, $parser)->make();
        })->afterCreating(function (Email $email) use ($parser) {
            collect($parser->getHeaders())->each(function ($value, $key) use ($email) {
                $this->buildEmailHeaderFactory($email, $key, $value)->create();
            });

            $this->buildEmailBodyFactory($email, $parser)->create();

            $this->buildEmailDetailFactory($email, $parser)->create();
        });
    }

    private function buildEmailDetailFactory(Email $email, Parser $parser): Factory
    {
        return EmailDetail::factory()
            ->withEmail($email)
            ->withTo(EmailStorage::extractEmailFrom($parser->getHeader('to')))
            ->withFrom(EmailStorage::extractEmailFrom($parser->getHeader('from')))
            ->withMessageID($parser->getHeader('message-id'))
            ->withSubject($parser->getHeader('subject'));
    }

    private function buildEmailBodyFactory(Email $email, Parser $parser): Factory
    {
        return EmailBody::factory()
            ->withEmail($email)
            ->withContent($parser->getMessageBody());
    }

    private function buildEmailHeaderFactory(Email $email, string $key, array|string $value): Factory
    {
        return EmailHeader::factory()
            ->withEmail($email)
            ->withHeader($key, $value);
    }
}
