<?php

namespace Tests\Unit;

use App\Livewire\ImportEmail;
use App\Models\Email;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\Traits\EmailStorageTestHelper;

class ImportEmailTest extends TestCase
{
    use EmailStorageTestHelper, RefreshDatabase;

    public function test_can_import_email_file()
    {
        $file = $this->getFakeTestFile();

        $testQuery = Email::where('signature', $this->getTestFileSignature());

        $this->assertFalse($testQuery->exists());

        Livewire::test(ImportEmail::class)
            ->set('file', $file)
            ->call('uploadFile')
            ->assertHasNoErrors(['file']);

        $this->assertTrue($testQuery->exists());
    }

    public function test_modal_is_closed_by_default()
    {
        Livewire::test(ImportEmail::class)
            ->assertSet('isOpen', false);
    }

    public function test_fails_import_validation()
    {
        Livewire::test(ImportEmail::class)
            ->set('file', $this->getFakeBadTestFile())
            ->call('uploadFile')
            ->assertHasErrors(['file' => 'mimes:eml']);
    }
}
