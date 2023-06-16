<?php

namespace App\Providers;

use Handlers\EmailSendHandler;
use Handlers\SmsSendHandler;
use Handlers\TelegramSendHandler;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(TelegramSendHandler::class, function ($app) {
            return new TelegramSendHandler(
            // $app->resolve(TelegramBot::class)
            );
        });

        $this->app->bind(EmailSendHandler::class, function ($app) {
            return new EmailSendHandler(
                // $app->resolve(EmailTransportService::class)
            );
        });

        $this->app->bind(SmsSendHandler::class, function ($app) {
            return new SmsSendHandler(
                // $app->resolve(SmsTransportService::class)
            );
        });
    }
}
