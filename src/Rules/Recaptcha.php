<?php

namespace Origami\Captcha\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Recaptcha implements ValidationRule
{
    /**
     * Indicates whether the rule should be implicit.
     *
     * @var bool
     */
    public $implicit = true;

    /**
     * Google ReCaptcha secret
     *
     * @var null|string
     */
    protected $secret;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($secret = null)
    {
        $this->secret = $secret ?: config('services.recaptcha.secret');
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $this->isRecaptchaValid()) {
            $fail(__('validation.recaptcha'));
        }
    }

    protected function isRecaptchaValid()
    {
        $recaptcha = new \ReCaptcha\ReCaptcha($this->secret);
        $response = $recaptcha->verify($this->getRecaptchaResponse(), $this->getRecaptchaIp());

        return $response->isSuccess();
    }

    protected function getRecaptchaResponse()
    {
        return app('request')->input('g-recaptcha-response');
    }

    protected function getRecaptchaIp()
    {
        return app('request')->ip();
    }
}
