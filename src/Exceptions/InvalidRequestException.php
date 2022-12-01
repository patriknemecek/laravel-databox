<?php

namespace LaravelDataBox\Exceptions;

use Illuminate\Http\Client\Response;
use RuntimeException;

class InvalidRequestException extends RuntimeException
{
    public static function fromResponse(Response $response): self
    {
        return new self($response->body(), $response->status());
    }
}
