<?php

namespace LaravelDataBox;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Assert as PHPUnit;

class DataBoxFake extends DataBox
{
    private array $metrics = [];

    public function __construct()
    {
        Http::fake([
            DataBoxApi::ENDPOINT.'*' => (function (Request $request) {
                $this->metrics = array_merge($this->metrics, json_decode($request->body(), true)['data']);

                return Http::response([
                    'success' => true,
                    'data' => ['id' => uniqid()],
                ], 200);
            }),
        ]);
    }

    public function assertSentCount(int $count = 1)
    {
        $realCount = count($this->metrics);

        PHPUnit::assertTrue(
            $realCount === $count,
            "Metrics count is not {$count} but {$realCount}"
        );
    }

    public function clearMetrics(): void
    {
        $this->metrics = [];
    }
}
