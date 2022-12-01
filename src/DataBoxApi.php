<?php

namespace LaravelDataBox;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use LaravelDataBox\DTOs\Metric;
use LaravelDataBox\DTOs\MetricKey;
use LaravelDataBox\Exceptions\InvalidRequestException;

class DataBoxApi
{
    public const ENDPOINT = 'https://push.databox.com';

    private string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function push(Metric|array $metrics): ?string
    {
        if (is_array($metrics)) {
            return $this->pushList($metrics);
        }
        $response = $this
            ->request()
            ->post('', [
                'data' => [$this->prepareKPIData($metrics)],
            ]);

        $this->validateResponse($response);

        return $response->json('data.id');
    }

    private function pushList(array $metrics): ?string
    {
        $response = $this
            ->request()
            ->post('', [
                'data' => array_map(fn (Metric $metric) => $this->prepareKPIData($metric), $metrics),
            ]);

        $this->validateResponse($response);

        return $response->json('data.id');
    }

    /**
     * @return MetricKey[]
     */
    public function metrics(): array
    {
        $response = $this
            ->request()
            ->get('/metrickeys');

        $this->validateResponse($response);

        $data = $response->json('metrics', []);

        return array_map(function (array $metricKey) {
            return new MetricKey(
                key: $metricKey['key'] ?? '',
                title: $metricKey['title'] ?? '',
                isAttributed: $metricKey['isAttributed'] ?? false,
            );
        }, $data);
    }

    public function purge(): void
    {
        $response = $this->request()->delete('/data');

        $this->validateResponse($response);
    }

    private function prepareKPIData(Metric $metric): array
    {
        $data = [sprintf('$%s', trim($metric->key, '$')) => $metric->value];

        if ($metric->date !== null) {
            $data['date'] = $metric->date->format('Y-m-d H:i:s');
        }

        if ($metric->unit !== null) {
            $data['unit'] = $metric->unit;
        }

        return $data + $metric->attributes;
    }

    private function request(): PendingRequest
    {
        return Http::baseUrl(self::ENDPOINT)
            ->withBasicAuth($this->token, '')
            ->asJson()
            ->accept('application/vnd.databox.v2+json');
    }

    private function validateResponse(Response $response): void
    {
        if (! $response->successful()) {
            throw InvalidRequestException::fromResponse($response);
        }

        if (! $response->json('success')) {
            throw InvalidRequestException::fromResponse($response);
        }
    }
}
