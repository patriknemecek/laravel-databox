<?php

namespace LaravelDataBox\Commands;

use Illuminate\Console\Command;

class LaravelDataBoxCommand extends Command
{
    public $signature = 'laravel-databox';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
