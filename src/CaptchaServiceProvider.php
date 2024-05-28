<?php

namespace Origami\Captcha;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Origami\Captcha\Validation\RecaptchaValidator;

class CaptchaServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }

    public function boot()
    {
        Blade::directive('recaptchaField', function ($expression) {
            return '<div class="g-recaptcha" data-sitekey="'.config('services.recaptcha.key').'"></div>';
        });

        Blade::directive('recaptchaScript', function ($expression) {
            return '<script src="https://www.google.com/recaptcha/api.js"></script>';
        });
    }
}
