<?php

namespace Weble\LaravelDatabox\Facades;

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Http;
use Weble\LaravelDatabox\DataBoxApi;
use Weble\LaravelDatabox\DataBoxFake;

/**
 * @see \Weble\LaravelDatabox\DataBox
 * @mixin \Weble\LaravelDatabox\DataBox
 */
class DataBox extends Facade
{
    public static function fake(): DataBoxFake
    {
        self::swap($fake = new DataBoxFake());

        return $fake;
    }

    protected static function getFacadeAccessor()
    {
        return \Weble\LaravelDatabox\DataBox::class;
    }
}
