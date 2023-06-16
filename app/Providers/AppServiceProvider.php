<?php

namespace App\Providers;

use app\Helpers\ContainerAdapter;
use app\Helpers\UserAdapter;

use Enot\Common\Contracts\ContainerInterface;
use Enot\Common\Contracts\UserInterface;
use Enot\Otp\Contracts\UserSettingsRepositoryInterface;
use Enot\Otp\Handlers\AbstractSendHandler;

use Illuminate\Support\ServiceProvider;
use Repositories\UserSettingsEloquentRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(UserInterface::class, UserAdapter::class);
        $this->app->bind(ContainerInterface::class, ContainerAdapter::class);
        $this->app->bind(UserSettingsRepositoryInterface::class, UserSettingsEloquentRepository::class);

        $this->bindOtpDependencies();

    }

    private function bindOtpDependencies()
    {
        $this->app->when(AbstractSendHandler::class)
            ->needs(UserSettingsRepositoryInterface::class)
            ->give(function ($app) {
                $app->make(UserSettingsRepositoryInterface::class);
            });
    }
}
