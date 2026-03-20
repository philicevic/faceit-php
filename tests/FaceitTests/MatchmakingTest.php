<?php

use Philicevic\FaceitPhp\DTO\Matchmaking\Matchmaking;
use Philicevic\FaceitPhp\DTO\Matchmaking\MatchmakingQueue;
use Philicevic\FaceitPhp\Requests\GetMatchmakingRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->faceit = faceitMock();
    $this->resource = $this->faceit->matchmaking();
});

test('can get matchmaking details', function () {
    MockClient::global([
        GetMatchmakingRequest::class => MockResponse::fixture('matchmaking_details'),
    ]);

    $mm = $this->resource->get('mm-abc123');

    expect($mm)->toBeInstanceOf(Matchmaking::class);
});

test('matchmaking details hydrates all attributes', function () {
    MockClient::global([
        GetMatchmakingRequest::class => MockResponse::fixture('matchmaking_details'),
    ]);

    $mm = $this->resource->get('mm-abc123');

    expect($mm->uuid)->toBe('mm-abc123')
        ->and($mm->name)->toBe('CS2 5v5 Premium')
        ->and($mm->game)->toBe('cs2')
        ->and($mm->region)->toBe('EU')
        ->and($mm->icon)->toBe('https://cdn.faceit.com/matchmaking/icon.png')
        ->and($mm->leagueId)->toBe('league-xyz789')
        ->and($mm->shortDescription)->toBe('Premium 5v5 matchmaking')
        ->and($mm->longDescription)->toContain('competitive CS2')
        ->and($mm->queues)->toHaveCount(2)
        ->and($mm->queues)->toContainOnlyInstancesOf(MatchmakingQueue::class);
});

test('matchmaking queues hydrate correctly', function () {
    MockClient::global([
        GetMatchmakingRequest::class => MockResponse::fixture('matchmaking_details'),
    ]);

    $mm = $this->resource->get('mm-abc123');
    $queue = $mm->queues[0];

    expect($queue->uuid)->toBe('queue-111')
        ->and($queue->name)->toBe('EU Premium Queue')
        ->and($queue->open)->toBeTrue()
        ->and($queue->organizerId)->toBe('org-faceit')
        ->and($queue->paused)->toBeFalse();

    $queue2 = $mm->queues[1];

    expect($queue2->uuid)->toBe('queue-222')
        ->and($queue2->paused)->toBeTrue();
});
