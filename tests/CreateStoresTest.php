<?php

use Weble\LaravelDatabox\DataBoxSource;
use Weble\LaravelDatabox\Facades\DataBox;

it('creates a default source', function () {
    $source = DataBox::source();

    expect($source)->toBeInstanceOf(DataBoxSource::class);
});

it('creates a named source', function () {
    $source = DataBox::source('default');

    expect($source)->toBeInstanceOf(DataBoxSource::class);
});

it('creates a named source with its configuration', function () {
    config()->set('databox.sources', [
        'test' => [
            'token' => '123',
            'queue' => true,
        ],
    ]);
    $source = DataBox::source('test');

    expect($source)
        ->toBeInstanceOf(DataBoxSource::class)
        ->and($source->name())->toBe('test')
        ->and($source->shouldQueue())->toBe(true);
});
