<?php

namespace Weble\LaravelDatabox\Commands;

use Illuminate\Console\Command;

class LaravelDataboxCommand extends Command
{
    public $signature = 'laravel-databox';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
