<?php

namespace App\Providers;

use Botble\Setting\Facades\Setting;
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
        $this->app->booted(function () {
            $this->_registerMailConfig();
        });
    }

    private function _registerMailConfig()
    {
        $mails = collect(json_decode(Setting::get(\Botble\Setting\Models\Setting::MAILS), true));
        if ($mails->count()) {
            if ($mails->has('smtp')) config(['mail.mailers.smtp' => collect(config('mail.mailers.smtp'))->merge($mails->get('smtp'))->toArray()]);
            if ($mails->has('smtp_pec')) config(['mail.mailers.smtp_pec' => collect(config('mail.mailers.smtp_pec'))->merge($mails->get('smtp_pec'))->toArray()]);
        }
    }
}
