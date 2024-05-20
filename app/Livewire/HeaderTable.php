<?php

namespace App\Livewire;

use App\Facades\EmailStorage;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class HeaderTable extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public int $emailId;

    #[Url(history: true)]
    public int $limit;

    #[Url(history: true)]
    public string $search;

    #[Url(history: true)]
    public string $sortDir;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function mount(string $id): void
    {
        $this->emailId = $id;
        $this->limit = 5;
        $this->sortDir = 'desc';
        $this->search = '';
    }

    public function delete(int $email_id): void
    {
        EmailStorage::delete($email_id);
    }

    public function render(): Factory|Application|View|\Illuminate\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.header-table', [
            'headers' => EmailStorage::headerSearch($this->emailId, $this->search, $this->limit, $this->sortDir),
        ]);
    }
}
