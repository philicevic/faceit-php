<?php

use Philicevic\FaceitPhp\DTO\Matchmaking\Matchmaking;
use Philicevic\FaceitPhp\DTO\Matchmaking\MatchmakingQueue;
use Philicevic\FaceitPhp\Requests\GetMatchmakingRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->faceit = faceitMock();
    $this->resource = $this->faceit->matchmaking();
    $this->matchmakingId = 'f4148ddd-bce8-41b8-9131-ee83afcdd6dd';
});

test('can get matchmaking details', function () {
    MockClient::global([
        GetMatchmakingRequest::class => MockResponse::fixture('matchmaking_details'),
    ]);

    $mm = $this->resource->get($this->matchmakingId);

    expect($mm)->toBeInstanceOf(Matchmaking::class);
});

test('matchmaking details hydrates all attributes', function () {
    MockClient::global([
        GetMatchmakingRequest::class => MockResponse::fixture('matchmaking_details'),
    ]);

    $mm = $this->resource->get($this->matchmakingId);

    expect($mm->uuid)->toBeString()->not->toBeEmpty()
        ->and($mm->name)->toBeString()->not->toBeEmpty()
        ->and($mm->game)->toBeString()->not->toBeEmpty()
        ->and($mm->region)->toBeString()->not->toBeEmpty()
        ->and($mm->icon)->toBeString()
        ->and($mm->leagueId)->toBeString()
        ->and($mm->shortDescription)->toBeString()
        ->and($mm->longDescription)->toBeString()
        ->and($mm->queues)->toBeArray()
        ->and($mm->queues)->toContainOnlyInstancesOf(MatchmakingQueue::class);
});

test('matchmaking queues hydrate correctly', function () {
    MockClient::global([
        GetMatchmakingRequest::class => MockResponse::fixture('matchmaking_details'),
    ]);

    $mm = $this->resource->get($this->matchmakingId);

    foreach ($mm->queues as $queue) {
        expect($queue->uuid)->toBeString()->not->toBeEmpty()
            ->and($queue->name)->toBeString()->not->toBeEmpty()
            ->and($queue->open)->toBeBool()
            ->and($queue->organizerId)->toBeString()->not->toBeEmpty()
            ->and($queue->paused)->toBeBool();
    }
});
