<?php

namespace LaravelDataBox;

use LaravelDataBox\DTOs\Metric;
use LaravelDataBox\DTOs\MetricKey;
use LaravelDataBox\Exceptions\UnknownSourceException;
use LaravelDataBox\Jobs\PushJob;

class DataBoxSource
{
    private array $config;

    private ?DataBoxApi $api = null;

    public function __construct(private string $name)
    {
        $this->loadConfig();
    }

    public function name(): string
    {
        return $this->name;
    }

    public function shouldQueue(): bool
    {
        return $this->config['queue'] ?? config('databox.queue', false);
    }

    /**
     * @param Metric|Metric[] $metrics
     * @return void
     */
    public function push(Metric|array $metrics): void
    {
        if ($this->shouldQueue()) {
            PushJob::dispatch(metrics: $metrics, sourceName: $this->name);

            return;
        }

        PushJob::dispatchAfterResponse(metrics: $metrics, sourceName: $this->name);
    }

    /** @return MetricKey[] */
    public function metrics(): array
    {
        return $this->api->metrics();
    }

    public function api(): DataBoxApi
    {
        if ($this->api === null) {
            $this->api = new DataBoxApi($this->config['token'] ?? '');
        }

        return $this->api;
    }

    private function loadConfig(): void
    {
        $sourceConfig = config('databox.sources.'.$this->name);
        if ($sourceConfig === null) {
            throw new UnknownSourceException("Source {$this->name} is not configured");
        }

        $this->config = $sourceConfig;
    }
}
