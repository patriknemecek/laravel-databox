<?php

namespace Weble\LaravelDatabox;


use Illuminate\Support\Arr;

class DataBox
{
    private array $sources = [];
    private array $stack = [];

    public function push(MetricDTO|array $metrics, ?string $sourceName = null): void
    {
        $metrics = Arr::wrap($metrics);

        $sourceName = $this->source($sourceName)->name();
        $this->stack[$sourceName] = array_merge($this->stack[$sourceName], $metrics);
    }

    public function source(?string $sourceName = null): DataBoxSource
    {
        $sourceName = $sourceName ?? config('databox.default_source', 'default');

        if (isset($this->sources[$sourceName])) {
            return $this->sources[$sourceName];
        }

        return $this->sources[$sourceName] = $this->createSource($sourceName);
    }

    public function forget(string $sourceName): self
    {
        unset($this->sources[$sourceName]);

        return $this;
    }

    public function sendAll(): void
    {
        foreach ($this->stack as $source => $metrics) {
            $this->source($source)->push($metrics);
        }
    }

    private function createSource(string $sourceName): DataBoxSource
    {
        return new DataBoxSource(
            name: $sourceName
        );
    }
}
