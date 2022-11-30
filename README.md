# Databox API integration for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/weble/laravel-databox.svg?style=flat-square)](https://packagist.org/packages/weble/laravel-databox)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/weble/laravel-databox/run-tests?label=tests)](https://github.com/weble/laravel-databox/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/weble/laravel-databox/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/weble/laravel-databox/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/weble/laravel-databox.svg?style=flat-square)](https://packagist.org/packages/weble/laravel-databox)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.


## Installation

You can install the package via composer:

```bash
composer require weble/laravel-databox
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-databox-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$laravelDatabox = new Weble\LaravelDatabox();
echo $laravelDatabox->echoPhrase('Hello, Weble!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Daniele Rosario](https://github.com/Skullbock)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
