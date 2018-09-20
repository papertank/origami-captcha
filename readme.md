# Origami Catpcha - Laravel Google ReCaptcha Integration

This package adds a validation rule and controller trait for easier integration with Google Recaptcha

## Installation

Install this package through Composer.

```
composer require origami/captcha
```

### Requirements

This package is designed to work with Laravel >= 5.4 currently.

### Service Provider

If you do not have package auto discovery, there is a Laravel 5 is a service provider you can make use of to automatically prepare the bindings.

```php

// app/config/app.php

‘providers’ => [
    ...
    Origami\Consent\ConsentServiceProvider::class
];
```

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
    'recaptcha' => 'recaptcha',
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
            'recatpcha' => 'recaptcha'
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
        $this->validateCatpcha($request);

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

## Author
[Papertank Limited](http://papertank.com)

## License
[MIT License](http://github.com/papertank/origami-captcha/blob/master/LICENSE)