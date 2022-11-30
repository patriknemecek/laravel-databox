<?php

namespace Weble\LaravelDatabox\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Weble\LaravelDatabox\DataBox;
use Weble\LaravelDatabox\MetricDTO;

class PushJob implements ShouldQueue
{
    use Batchable;
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(private MetricDTO|array $metrics, private ?string $sourceName = null)
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
