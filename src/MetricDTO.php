<?php

namespace Weble\LaravelDatabox;

use DateTimeInterface;

class MetricDTO
{
    public function __construct(public string $key, public int|float $value, public ?DateTimeInterface $date = null, public array $attributes = [], public ?string $unit = null)
    {
    }
}
