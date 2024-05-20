<?php

namespace App\Providers;

use App\Repository\BodyRepository;
use App\Repository\BodyRepositoryContract;
use App\Repository\EmailRepository;
use App\Repository\EmailRepositoryContract;
use App\Repository\HeaderRepository;
use App\Repository\HeaderRepositoryContract;
use App\Services\EmailStorageService;
use App\Services\EmailStorageServiceContract;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class EmailStorageServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(EmailRepositoryContract::class, function () {
            return new EmailRepository();
        });

        $this->app->singleton(HeaderRepositoryContract::class, function () {
            return new HeaderRepository();
        });

        $this->app->singleton(BodyRepositoryContract::class, function () {
            return new BodyRepository();
        });

        $this->app->singleton(EmailStorageServiceContract::class, function (Application $application) {
            return new EmailStorageService(
                $application->get(EmailRepositoryContract::class),
                $application->get(HeaderRepositoryContract::class)
            );
        });
    }

    public function provides(): array
    {
        return [
            EmailStorageServiceContract::class,
            EmailRepositoryContract::class,
            BodyRepositoryContract::class,
        ];
    }
}
