<?php

namespace LaravelDataBox\DTOs;

use DateTimeInterface;

class MetricKey
{
    public function __construct(public string $key, public string $title, public bool $isAttributed)
    {
    }
}
