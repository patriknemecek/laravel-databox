# Databox integration for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/weble/laravel-databox.svg?style=flat-square)](https://packagist.org/packages/weble/laravel-databox)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/weble/laravel-databox/run-tests?label=tests)](https://github.com/weble/laravel-databox/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/weble/laravel-databox/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/weble/laravel-databox/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/weble/laravel-databox.svg?style=flat-square)](https://packagist.org/packages/weble/laravel-databox)

Databox integration for Laravel, with support for **sending metrics** and retrieving lists of availble metrics. 

The data gets send in a **single push request after the Laravel application has finished sending the response** to avoid impacting the users. Pushing data can also be moved to the **queue** via a simple option in the config file

## Example Usage

```php
use \LaravelDataBox\Facades\DataBox;

// gets the default source
$source = DataBox::source();

// Push a new metric
$source->push(new Metric(
    key: 'sales', 
    value: 888.22, 
));
```



## Installation

You can install the package via composer:

```bash
composer require weble/laravel-databox
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-databox-config"
```

This is the contents of the published config file, with each option commented:

```php
<?php

return [

    // name of the default source, used when not passing a specific source name
    'default_source' => 'default',

    // should the data be pushed with a queued job?
    // default setting, can be overridden per source
    'queue' => false,

    // List of sources, you can create as many as you want, each with its
    // own token and queue setting
    'sources' => [

        'default' => [

            // The token generated in the databox UI
            'token' => env('DATABOX_TOKEN', ''),

            // Each source can override the queue setting.
            // null means use the default setting above
            'queue' => null,
        ],
        
        // More sources....
    ],
];
```

## Usage

You can interact with the DataBox APIs through the facade `LaravelDataBox\Facades\DataBox`

### Push a single metric

```php
use \LaravelDataBox\Facades\DataBox;

// gets the default source
$source = DataBox::source();

// Push a new metric
$source->push(new Metric(
    key: 'sales', // Adds automatically the $ sign if not present
    value: 888.22, // any float / int value
));
```

### Push multiple metrics

```php
use \LaravelDataBox\Facades\DataBox;

$source = DataBox::source();
$source->push([
    new Metric(
        key: 'sales',
        value: 888.22, 
    ),
    new Metric(
        key: 'sales', 
        value: 72,
    ),
]);
```

### Full list of metric options

```php
use \LaravelDataBox\Facades\DataBox;

$source = DataBox::source();
$source->push(new Metric(
    key: 'sales',
    value: 888.22, 
    date: now()->subDay(), // date of the metric event
    attributes: [ // Custom attributes for dimensions
        'channel' => 'sales'
    ],
    'unit' => 'EUR', // Unit of the value
));
```

### Use a different source

```php
use \LaravelDataBox\Facades\DataBox;

$source = DataBox::source('other_source');
$source->push(new Metric(
    key: 'sales',
    value: 888.22
));
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
