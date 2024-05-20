<?php

namespace App\Livewire;

use App\Facades\EmailStorage;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class EmailViewer extends Component
{
    public int $id;

    public function mount($id): void
    {
        $email = EmailStorage::find($id);

        if (! $email) {
            $this->redirect('/');

            return;
        }

        $this->id = $email->id;
    }

    public function render(): Factory|Application|View|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.email-viewer', [
            'email' => EmailStorage::find($this->id),
        ]);
    }
}
