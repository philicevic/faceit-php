<?php

use Philicevic\FaceitPhp\DTO\Leaderboard\EntityRanking;
use Philicevic\FaceitPhp\DTO\Leaderboard\Leaderboard;
use Philicevic\FaceitPhp\DTO\Leaderboard\Ranking;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\Requests\GetChampionshipGroupRankingRequest;
use Philicevic\FaceitPhp\Requests\GetChampionshipLeaderboardsRequest;
use Philicevic\FaceitPhp\Requests\GetHubLeaderboardsRequest;
use Philicevic\FaceitPhp\Requests\GetHubRankingRequest;
use Philicevic\FaceitPhp\Requests\GetHubSeasonRankingRequest;
use Philicevic\FaceitPhp\Requests\GetLeaderboardRequest;
use Philicevic\FaceitPhp\Requests\GetPlayerLeaderboardRankingRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->faceit = faceitMock();
});

test('can get championship leaderboards', function () {
    MockClient::global([
        GetChampionshipLeaderboardsRequest::class => MockResponse::fixture('leaderboard_list'),
    ]);

    $response = $this->faceit->leaderboard()->getChampionshipLeaderboards('champ-uuid-1');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Leaderboard::class);
});

test('can get championship group ranking', function () {
    MockClient::global([
        GetChampionshipGroupRankingRequest::class => MockResponse::fixture('leaderboard_details'),
    ]);

    $ranking = $this->faceit->leaderboard()->getChampionshipGroupRanking('champ-uuid-1', 1);

    expect($ranking)->toBeInstanceOf(EntityRanking::class)
        ->and($ranking->leaderboard)->toBeInstanceOf(Leaderboard::class)
        ->and($ranking->items)->toContainOnlyInstancesOf(Ranking::class);
});

test('can get hub leaderboards', function () {
    MockClient::global([
        GetHubLeaderboardsRequest::class => MockResponse::fixture('leaderboard_list'),
    ]);

    $response = $this->faceit->leaderboard()->getHubLeaderboards('hub-uuid-1');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Leaderboard::class);
});

test('can get hub ranking', function () {
    MockClient::global([
        GetHubRankingRequest::class => MockResponse::fixture('leaderboard_details'),
    ]);

    $ranking = $this->faceit->leaderboard()->getHubRanking('hub-uuid-1');

    expect($ranking)->toBeInstanceOf(EntityRanking::class)
        ->and($ranking->items)->toContainOnlyInstancesOf(Ranking::class);
});

test('can get hub season ranking', function () {
    MockClient::global([
        GetHubSeasonRankingRequest::class => MockResponse::fixture('leaderboard_details'),
    ]);

    $ranking = $this->faceit->leaderboard()->getHubSeasonRanking('hub-uuid-1', 1);

    expect($ranking)->toBeInstanceOf(EntityRanking::class);
});

test('can get leaderboard', function () {
    MockClient::global([
        GetLeaderboardRequest::class => MockResponse::fixture('leaderboard_details'),
    ]);

    $ranking = $this->faceit->leaderboard()->get('lb-uuid-1');

    expect($ranking)->toBeInstanceOf(EntityRanking::class);
});

test('leaderboard entity ranking hydrates all attributes', function () {
    MockClient::global([
        GetLeaderboardRequest::class => MockResponse::fixture('leaderboard_details'),
    ]);

    $ranking = $this->faceit->leaderboard()->get('lb-uuid-1');
    $entry = $ranking->items[0];

    expect($ranking->start)->toBe(0)
        ->and($ranking->end)->toBe(1)
        ->and($ranking->leaderboard->leaderboardId)->toBe('lb-uuid-1')
        ->and($ranking->leaderboard->leaderboardName)->toBe('Main Leaderboard')
        ->and($ranking->leaderboard->gameId)->toBe('cs2')
        ->and($entry->position)->toBe(1)
        ->and($entry->points)->toBe(150)
        ->and($entry->won)->toBe(40)
        ->and($entry->player->uuid)->toBe('player-uuid-1')
        ->and($entry->player->nickname)->toBe('TopPlayer');
});

test('can get player leaderboard ranking', function () {
    MockClient::global([
        GetPlayerLeaderboardRankingRequest::class => MockResponse::fixture('player_leaderboard_ranking'),
    ]);

    $ranking = $this->faceit->leaderboard()->getPlayerRanking('lb-uuid-1', 'player-uuid-1');

    expect($ranking)->toBeInstanceOf(Ranking::class);
});

test('player leaderboard ranking hydrates all attributes', function () {
    MockClient::global([
        GetPlayerLeaderboardRankingRequest::class => MockResponse::fixture('player_leaderboard_ranking'),
    ]);

    $ranking = $this->faceit->leaderboard()->getPlayerRanking('lb-uuid-1', 'player-uuid-1');

    expect($ranking->position)->toBe(42)
        ->and($ranking->points)->toBe(120)
        ->and($ranking->won)->toBe(20)
        ->and($ranking->player->uuid)->toBe('player-uuid-1')
        ->and($ranking->player->country)->toBe('DE');
});
