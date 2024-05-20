<?php

namespace Tests\Traits;

use Database\Factories\AbstractEmailBaseFactory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PhpMimeMailParser\Parser;

trait EmailStorageTestHelper
{
    public function getTestParser(): Parser
    {
        return (new Parser())->setText(
            $this->getTestFile()
        );
    }

    public function getTestFilePath(): string
    {
        return AbstractEmailBaseFactory::EMAIL_DIRECTORY.'/'.$this->getTestFileName();
    }

    public function getTestFile(): string
    {
        return Storage::get($this->getTestFilePath());
    }

    public function getTestFileName(): string
    {
        return AbstractEmailBaseFactory::SEEDED_TEST_EMAIL_PATH;
    }

    public function getFakeTestFile(): UploadedFile
    {
        $path = Storage::path($this->getTestFilePath());

        return UploadedFile::fake()->createWithContent('test-file.eml', file_get_contents($path));
    }

    public function getFakeBadTestFile(): UploadedFile
    {
        return UploadedFile::fake()->image(
            name: 'bad-test-file'
        );
    }

    public function getTestFileSignature(): string
    {
        return md5($this->getTestFile());
    }
}
