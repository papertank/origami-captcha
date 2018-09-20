<?php

namespace Origami\Captcha\Validation;

use ReCaptcha\ReCaptcha;

class RecaptchaValidator
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        if (app()->environment('testing')) {
            return true;
        }

        $recaptcha = new ReCaptcha(config('services.recaptcha.secret'));
        $response = $recaptcha->verify($this->getResponse(), $this->getIp());

        return $response->isSuccess();
    }

    protected function getResponse()
    {
        return app('request')->input('g-recaptcha-response');
    }

    protected function getIp()
    {
        return app('request')->ip();
    }
}
