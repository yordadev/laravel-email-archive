<?php

namespace Database\Seeders;

use App\Models\Email;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class StoreTestEmail extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $path = __DIR__.'/emails/host-with-us_-hacker-x--a-i-san-francisco–-a-premier-a-i-event!.eml';

        if (file_exists($path)) {
            $contents = file_get_contents($path);
            Storage::put('emails/host-with-us_-hacker-x--a-i-san-francisco–-a-premier-a-i-event!.eml', $contents);
        }

        Email::factory()->create();
    }
}
