<?php

namespace App\Jobs;

use App\Repository\BodyRepository;
use App\Repository\HeaderRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use PhpMimeMailParser\Parser;

class ProcessImportedEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected int $emailId,
        protected string $tempLocalPath
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(HeaderRepository $headerRepository, BodyRepository $bodyRepository): void
    {
        $emailParser = (new Parser())->setPath(Storage::disk('local')->path($this->tempLocalPath));
        $headerRepository->store($this->emailId, $emailParser->getHeaders());
        $bodyRepository->store($this->emailId, $emailParser->getMessageBody());
    }
}
