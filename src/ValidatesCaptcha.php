<?php

namespace Origami\Captcha;

use Illuminate\Http\Request;
use Origami\Captcha\Rules\Recaptcha;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait ValidatesCaptcha
{
    public function validateRecaptcha(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'recaptcha' => [new Recaptcha],
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return true;
    }
}
