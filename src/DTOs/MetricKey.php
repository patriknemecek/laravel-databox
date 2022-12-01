<?php

namespace LaravelDataBox\DTOs;

class MetricKey
{
    public function __construct(public string $key, public string $title, public bool $isAttributed)
    {
    }
}
