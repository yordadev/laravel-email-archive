<?php

namespace Tests\Unit;

use App\Livewire\HeaderTable;
use App\Models\Email;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\EmailStorageTestHelper;

class HeaderTableTest extends TestCase
{
    use EmailStorageTestHelper, RefreshDatabase;

    public function test_it_can_render_with_headers()
    {
        $email = Email::factory()->create();

        Livewire::test(HeaderTable::class, ['id' => $email->id])
            ->assertViewHas('headers', function ($headers) use ($email) {
                return $headers->total() === $email->headers()->count();
            });
    }

    public function test_it_can_search_headers()
    {
        $value = 'testValue';
        $key = 'testKey';

        $search = 'lue';

        $email = Email::factory()->create();

        $email->headers()->create([
            'email_id' => $email->id,
            'key' => $key,
            'value' => $value,
        ]);

        Livewire::test(HeaderTable::class, ['id' => $email->id])
            ->set('search', $search)
            ->assertViewHas('headers', function ($headers) use ($value) {
                return $headers->total() === 1 && $headers->first()->value === $value;
            });
    }
}
