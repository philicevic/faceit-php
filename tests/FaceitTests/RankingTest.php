<?php

use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Ranking\GlobalRanking;
use Philicevic\FaceitPhp\DTO\Ranking\PlayerRanking;
use Philicevic\FaceitPhp\Requests\GetGlobalRankingRequest;
use Philicevic\FaceitPhp\Requests\GetPlayerRankingRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->faceit = faceitMock();
});

test('can get global ranking', function () {
    MockClient::global([
        GetGlobalRankingRequest::class => MockResponse::fixture('global_ranking'),
    ]);

    $response = $this->faceit->ranking()->getGlobal('cs2', 'EU');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(GlobalRanking::class);
});

test('global ranking hydrates all attributes', function () {
    MockClient::global([
        GetGlobalRankingRequest::class => MockResponse::fixture('global_ranking'),
    ]);

    $response = $this->faceit->ranking()->getGlobal('cs2', 'EU');
    $entry = $response->items[0];

    expect($response->start)->toBe(0)
        ->and($response->end)->toBe(2)
        ->and($entry->uuid)->toBe('player-uuid-1')
        ->and($entry->nickname)->toBe('TopPlayer')
        ->and($entry->country)->toBe('DE')
        ->and($entry->faceitElo)->toBe(2500)
        ->and($entry->gameSkillLevel)->toBe(10)
        ->and($entry->position)->toBe(1);
});

test('can get player ranking', function () {
    MockClient::global([
        GetPlayerRankingRequest::class => MockResponse::fixture('player_global_ranking'),
    ]);

    $ranking = $this->faceit->ranking()->getPlayer('cs2', 'EU', 'player-uuid-1');

    expect($ranking)->toBeInstanceOf(PlayerRanking::class);
});

test('player ranking hydrates all attributes', function () {
    MockClient::global([
        GetPlayerRankingRequest::class => MockResponse::fixture('player_global_ranking'),
    ]);

    $ranking = $this->faceit->ranking()->getPlayer('cs2', 'EU', 'player-uuid-1');

    expect($ranking->position)->toBe(42)
        ->and($ranking->ranking)->toBeInstanceOf(PaginatedResponse::class)
        ->and($ranking->ranking->items)->toContainOnlyInstancesOf(GlobalRanking::class);
});
