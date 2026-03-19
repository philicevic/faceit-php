<?php

use Philicevic\FaceitPhp\DTO\Matchmaking\Matchmaking;
use Philicevic\FaceitPhp\DTO\Matchmaking\Queue;
use Philicevic\FaceitPhp\Requests\GetMatchmakingRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->faceit = faceitMock();
});

test('can get matchmaking', function () {
    MockClient::global([
        GetMatchmakingRequest::class => MockResponse::fixture('matchmaking_details'),
    ]);

    $matchmaking = $this->faceit->matchmaking()->get('mm-uuid-1');

    expect($matchmaking)->toBeInstanceOf(Matchmaking::class);
});

test('matchmaking hydrates all attributes', function () {
    MockClient::global([
        GetMatchmakingRequest::class => MockResponse::fixture('matchmaking_details'),
    ]);

    $matchmaking = $this->faceit->matchmaking()->get('mm-uuid-1');

    expect($matchmaking->uuid)->toBe('mm-uuid-1')
        ->and($matchmaking->name)->toBe('CS2 Matchmaking EU')
        ->and($matchmaking->game)->toBe('cs2')
        ->and($matchmaking->region)->toBe('EU')
        ->and($matchmaking->leagueId)->toBe('league-1')
        ->and($matchmaking->queues)->toContainOnlyInstancesOf(Queue::class);
});

test('matchmaking queue hydrates all attributes', function () {
    MockClient::global([
        GetMatchmakingRequest::class => MockResponse::fixture('matchmaking_details'),
    ]);

    $matchmaking = $this->faceit->matchmaking()->get('mm-uuid-1');
    $queue = $matchmaking->queues[0];

    expect($queue->uuid)->toBe('queue-1')
        ->and($queue->name)->toBe('Standard')
        ->and($queue->organizerId)->toBe('org-1')
        ->and($queue->open)->toBeTrue()
        ->and($queue->paused)->toBeFalse();
});
