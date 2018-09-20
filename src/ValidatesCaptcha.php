<?php

namespace Origami\Captcha;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait ValidatesCaptcha
{
    public function validateReCaptcha(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'recaptcha' => 'recaptcha',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return true;
    }
}
