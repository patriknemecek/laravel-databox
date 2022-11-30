<?php

namespace Weble\LaravelDatabox;

use DateTimeInterface;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Weble\LaravelDatabox\Exceptions\InvalidRequestException;

class DataBoxApi
{
    public const ENDPOINT = 'https://push.databox.com';

    private string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function push(MetricDTO|array $metrics): ?string
    {
        if (is_array($metrics)) {
            return $this->pushList($metrics);
        }
        $response = $this
            ->request()
            ->post('', [
                'data' => [$this->prepareKPIData($metrics)]
            ]);

        $this->validateResponse($response);

        return $response->json('data.id');
    }

    private function pushList(array $metrics): ?string
    {
        $response = $this
            ->request()
            ->post('', [
                'data' => array_map(fn(MetricDTO $metric) => $this->prepareKPIData($metric), $metrics)
            ]);

        $this->validateResponse($response);

        return $response->json('data.id');
    }

    public function lastPush(int $n = 1): array
    {
        $response = $this
            ->request()
            ->get(sprintf('/lastpushes?limit=%d', $n));

        $this->validateResponse($response);

        return $response->json('data', []);
    }

    public function getPush(array|string $sha): array
    {
        if (!is_array($sha)) {
            $sha = [$sha];
        }

        if (empty($sha)) {
            return [];
        }

        $response = $this
            ->request()
            ->get('/lastpushes?id=' . implode(',', $sha));

        $this->validateResponse($response);

        return $response->json('data', []);
    }

    public function metrics(): array
    {
        $response = $this
            ->request()
            ->get('/metrickeys');

        $this->validateResponse($response);

        return $response->json('data', []);
    }

    public function purge(): void
    {
        $response = $this->request()->delete('/data');

        $this->validateResponse($response);
    }

    private function prepareKPIData(MetricDTO $metric): array
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
        if (!$response->successful()) {
            throw InvalidRequestException::fromResponse($response);
        }

        if (!$response->json('success')) {
            throw InvalidRequestException::fromResponse($response);
        }
    }
}
