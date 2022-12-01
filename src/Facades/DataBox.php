<?php

namespace LaravelDataBox\Facades;

use Illuminate\Support\Facades\Facade;
use LaravelDataBox\DataBoxFake;

/**
 * @see \LaravelDataBox\DataBox
 * @mixin \LaravelDataBox\DataBox
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
        return \LaravelDataBox\DataBox::class;
    }
}
