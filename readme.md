# Origami Catpcha - Laravel Google ReCaptcha Integration

This package adds a validation rule and controller trait for easier integration with Google Recaptcha

## Installation

Install this package through Composer.

```
composer require origami/captcha
```

### Requirements

This package is designed to work with Laravel >= 10 currently. If you require 5.8 support, use version 1. If you require 6-7 support use version 2.

### Setup

1. Signup for a Google Recaptcha account at https://www.google.com/recaptcha/admin

2. You should add a recatpcha section to your `config/services.php` file:

```php
    
    'recaptcha' => [
        'key' => env('RECAPTCHA_KEY'),
        'secret' => env('RECAPTCHA_SECRET'),
    ],

```

3. Update your `.env` file with the key and secret:

```
RECAPTCHA_KEY=
RECAPTCHA_SECRET=
```

4. Add a language line to your validation file(s), e.g. `resources/lang/en/validation.php`

```

    'recaptcha' => 'The reCAPTCHA check was invalid',

```

## Usage

### Validator

```php
$validator = Validator::make($request->all(), [
    'recaptcha' => [new Origami\Captcha\Rules\Recaptcha],
]);
```

### Controller Validation

(Assuming your Controller has the `ValidatesRequests` trait)

```php
class Contact extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'recatpcha' => [new Origami\Captcha\Rules\Recaptcha]
        ]);
    }
}
```

### Changing Google secret

If you have multiple Recaptcha secrets (e.g. for different versions), you can customise in the rule params. Otherwise it will default to `config('services.recaptcha.secret')`

```php
class Contact extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'recatpcha' => [new Origami\Captcha\Rules\Recaptcha(secret: '123')]
        ]);
    }
}
```

### Controller with ValidatesCaptcha Trait

```php

use Origami\Captcha\ValidatesCaptcha;

class Contact extends Controller
{
    use ValidatesCaptcha;

    public function store(Request $request)
    {
        $this->validateRecaptcha($request);

        // The above will throw a ValidationException when the recaptcha fails.
    }

}
```

## Blade Helpers

This packages registers two Blade helpers:

`@recaptchaField` is the equivalent of:

```
<div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key') }}"></div>
```

`@recaptchaScript` is the equivalent of:

```
<script src="https://www.google.com/recaptcha/api.js"></script>
```

## Upgrading

### From v2 to v3

Version 3 was created to add Laravel 11.x support and drop support for Laravel versions before 10.x. This is a breaking change as the package now relies on [Rule Objects](https://laravel.com/docs/10.x/validation#using-rule-objects).

```
// Before
$validator = Validator::make($request->all(), [
    'recaptcha' => 'recaptcha',
]);

// After
$validator = Validator::make($request->all(), [
    'recaptcha' => [new Origami\Captcha\Rules\Recaptcha],
]);
```

The `ValidatesCaptcha` trait `validateReCaptcha` method has been renamed `validateRecaptcha`

## Author
- [David Rushton](https://github.com/davidrushton)
- [Papertank Limited](http://papertank.com)

## License
[MIT License](http://github.com/papertank/origami-captcha/blob/master/LICENSE)