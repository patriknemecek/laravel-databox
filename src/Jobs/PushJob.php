<?php

namespace LaravelDataBox\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use LaravelDataBox\DataBox;
use LaravelDataBox\DTOs\Metric;

class PushJob implements ShouldQueue
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(private Metric|array $metrics, private ?string $sourceName = null)
    {
    }

    public function handle(DataBox $dataBox): void
    {
        if ($this->batch()?->cancelled()) {
            return;
        }

        $dataBox
            ->source($this->sourceName)
            ->api()
            ->push($this->metrics);
    }
}
