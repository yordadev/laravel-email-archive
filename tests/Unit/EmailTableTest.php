<?php

namespace Tests\Unit;

use App\Livewire\EmailTable;
use App\Models\Email;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\EmailStorageTestHelper;

class EmailTableTest extends TestCase
{
    use EmailStorageTestHelper, RefreshDatabase;

    public function test_it_can_render_with_emails()
    {
        $count = 15;
        Email::factory()->count($count)->create();

        Livewire::test(EmailTable::class)
            ->assertViewHas('emails', function ($emails) use ($count) {
                return $emails->total() === $count;
            });
    }

    public function test_it_can_search()
    {
        $count = 5;
        $search = 'ar';
        $subject = 'Foo Bar';
        $emails = Email::factory()->count($count)->create();

        $testEmail = $emails->first();
        $testEmail->detail->update(['subject' => $subject]);

        Livewire::test(EmailTable::class)
            ->set('search', $search)
            ->assertViewHas('emails', function ($emails) use ($subject) {
                return $emails->count() === 1 && $emails->first()->detail->subject === $subject;
            });
    }
}
