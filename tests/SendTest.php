<?php

use Illuminate\Support\Facades\Queue;
use LaravelDataBox\DTOs\Metric;
use LaravelDataBox\Facades\DataBox;
use LaravelDataBox\Jobs\PushJob;

it('Sends Data After Request', function () {
    $fake = DataBox::fake();

    DataBox::source()->push(
        new Metric(
            key: 'test',
            value: 1,
        )
    );

    DataBox::source()->push(
        new Metric(
            key: 'test',
            value: 2,
        )
    );

    app()->terminate();

    $fake->assertSentCount(2);
});

it('Sends Data After Request queueing', function () {
    $queue = Queue::fake();
    config()->set('databox.queue', true);
    $fake = DataBox::fake();

    DataBox::source()->push(
        new Metric(
            key: 'test',
            value: 1,
        )
    );

    DataBox::source()->push(
        new Metric(
            key: 'test',
            value: 2,
        )
    );

    app()->terminate();

    $fake->assertSentCount(0);
    $queue->assertPushed(PushJob::class);
});
