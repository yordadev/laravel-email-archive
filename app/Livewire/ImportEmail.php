<?php

namespace App\Livewire;

use App\Facades\EmailStorage;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;

class ImportEmail extends ModalComponent
{
    use WithFileUploads;

    public $file;

    public $isOpen = false;

    protected $listeners = ['openModal', 'closeModal'];

    public function openModal(): void
    {
        $this->isOpen = true;
    }

    public function closeModal(): void
    {
        $this->isOpen = false;
    }

    public function uploadFile(): void
    {
        $this->validate([
            'file' => ['required', 'file', 'mimes:eml', 'max:1024'],
        ]);

        EmailStorage::store($this->file);

        $this->file->delete();

        $this->redirect('/');
    }

    public function render(): Factory|\Illuminate\Foundation\Application|View|\Illuminate\View\View|Application
    {
        return view('livewire.import-email');
    }
}
