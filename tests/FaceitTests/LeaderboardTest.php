<?php

use Philicevic\FaceitPhp\DTO\Leaderboard\EntityRanking;
use Philicevic\FaceitPhp\DTO\Leaderboard\Leaderboard;
use Philicevic\FaceitPhp\DTO\Leaderboard\RankingItem;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\UserSimple;
use Philicevic\FaceitPhp\Requests\GetChampionshipGroupRankingRequest;
use Philicevic\FaceitPhp\Requests\GetChampionshipLeaderboardsRequest;
use Philicevic\FaceitPhp\Requests\GetHubLeaderboardsRequest;
use Philicevic\FaceitPhp\Requests\GetHubRankingRequest;
use Philicevic\FaceitPhp\Requests\GetLeaderboardRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->faceit = faceitMock();
    $this->leaderboard = $this->faceit->leaderboard();
});

// --- Championship leaderboards ---

test('can get championship leaderboards', function () {
    MockClient::global([
        GetChampionshipLeaderboardsRequest::class => MockResponse::fixture('leaderboard_championship_list'),
    ]);

    $response = $this->leaderboard->getChampionshipLeaderboards('championship-abc123');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Leaderboard::class);
});

test('championship leaderboards hydrate all attributes', function () {
    MockClient::global([
        GetChampionshipLeaderboardsRequest::class => MockResponse::fixture('leaderboard_championship_list'),
    ]);

    $response = $this->leaderboard->getChampionshipLeaderboards('championship-abc123');
    $lb = $response->items[0];

    expect($response->start)->toBe(0)
        ->and($response->end)->toBe(1)
        ->and($lb->uuid)->toBe('lb-champ-001')
        ->and($lb->competitionId)->toBe('championship-abc123')
        ->and($lb->competitionType)->toBe('championship')
        ->and($lb->gameId)->toBe('cs2')
        ->and($lb->region)->toBe('EU')
        ->and($lb->leaderboardMode)->toBe('score')
        ->and($lb->leaderboardName)->toBe('Season 56 Leaderboard')
        ->and($lb->leaderboardType)->toBe('general')
        ->and($lb->minMatches)->toBe(5)
        ->and($lb->pointsPerDraw)->toBe(1)
        ->and($lb->pointsPerLoss)->toBe(0)
        ->and($lb->pointsPerWin)->toBe(3)
        ->and($lb->pointsType)->toBe('elo')
        ->and($lb->rankingBoost)->toBe(0)
        ->and($lb->rankingType)->toBe('default')
        ->and($lb->round)->toBe(14)
        ->and($lb->season)->toBe(56)
        ->and($lb->startDate)->toBe(1709000000)
        ->and($lb->endDate)->toBe(1711000000)
        ->and($lb->startingPoints)->toBe(1000)
        ->and($lb->status)->toBe('active')
        ->and($lb->group)->toBe(1);
});

// --- Championship group ranking ---

test('can get championship group ranking', function () {
    MockClient::global([
        GetChampionshipGroupRankingRequest::class => MockResponse::fixture('leaderboard_championship_group_ranking'),
    ]);

    $ranking = $this->leaderboard->getChampionshipGroupRanking('championship-abc123', 1);

    expect($ranking)->toBeInstanceOf(EntityRanking::class)
        ->and($ranking->leaderboard)->toBeInstanceOf(Leaderboard::class)
        ->and($ranking->items)->toContainOnlyInstancesOf(RankingItem::class);
});

test('championship group ranking hydrates all attributes', function () {
    MockClient::global([
        GetChampionshipGroupRankingRequest::class => MockResponse::fixture('leaderboard_championship_group_ranking'),
    ]);

    $ranking = $this->leaderboard->getChampionshipGroupRanking('championship-abc123', 1);
    $item = $ranking->items[0];

    expect($ranking->start)->toBe(0)
        ->and($ranking->end)->toBe(2)
        ->and($ranking->leaderboard->uuid)->toBe('lb-champ-001')
        ->and($ranking->leaderboard->competitionType)->toBe('championship')
        ->and($item->position)->toBe(1)
        ->and($item->points)->toBe(42)
        ->and($item->played)->toBe(14)
        ->and($item->won)->toBe(13)
        ->and($item->lost)->toBe(1)
        ->and($item->draw)->toBe(0)
        ->and($item->currentStreak)->toBe(5)
        ->and($item->winRate)->toBe(92.86)
        ->and($item->player)->toBeInstanceOf(UserSimple::class)
        ->and($item->player->uuid)->toBe('a58f6134-4f31-4611-8431-b0a9630bea77')
        ->and($item->player->nickname)->toBe('xqsp4m')
        ->and($item->player->skillLevel)->toBe(10);
});

// --- Hub leaderboards ---

test('can get hub leaderboards', function () {
    MockClient::global([
        GetHubLeaderboardsRequest::class => MockResponse::fixture('leaderboard_hub_list'),
    ]);

    $response = $this->leaderboard->getHubLeaderboards('05f970ad-b6a9-4740-89d1-a9fea46f7525');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Leaderboard::class);
});

test('hub leaderboards hydrate all attributes', function () {
    MockClient::global([
        GetHubLeaderboardsRequest::class => MockResponse::fixture('leaderboard_hub_list'),
    ]);

    $lb = $this->leaderboard->getHubLeaderboards('05f970ad-b6a9-4740-89d1-a9fea46f7525')->items[0];

    expect($lb->uuid)->toBe('lb-hub-001')
        ->and($lb->competitionId)->toBe('05f970ad-b6a9-4740-89d1-a9fea46f7525')
        ->and($lb->competitionType)->toBe('hub')
        ->and($lb->gameId)->toBe('cs2')
        ->and($lb->leaderboardName)->toBe('Hub All-Time Leaderboard');
});

// --- Hub ranking ---

test('can get hub ranking', function () {
    MockClient::global([
        GetHubRankingRequest::class => MockResponse::fixture('leaderboard_hub_ranking'),
    ]);

    $ranking = $this->leaderboard->getHubRanking('05f970ad-b6a9-4740-89d1-a9fea46f7525');

    expect($ranking)->toBeInstanceOf(EntityRanking::class)
        ->and($ranking->items)->toContainOnlyInstancesOf(RankingItem::class);
});

test('hub ranking hydrates all attributes', function () {
    MockClient::global([
        GetHubRankingRequest::class => MockResponse::fixture('leaderboard_hub_ranking'),
    ]);

    $ranking = $this->leaderboard->getHubRanking('05f970ad-b6a9-4740-89d1-a9fea46f7525');
    $item = $ranking->items[0];

    expect($ranking->leaderboard->uuid)->toBe('lb-hub-001')
        ->and($ranking->leaderboard->competitionType)->toBe('hub')
        ->and($ranking->start)->toBe(0)
        ->and($ranking->end)->toBe(1)
        ->and($item->position)->toBe(1)
        ->and($item->points)->toBe(1850)
        ->and($item->played)->toBe(120)
        ->and($item->won)->toBe(85)
        ->and($item->lost)->toBe(35)
        ->and($item->currentStreak)->toBe(8)
        ->and($item->winRate)->toBe(70.83)
        ->and($item->player->uuid)->toBe('a58f6134-4f31-4611-8431-b0a9630bea77')
        ->and($item->player->nickname)->toBe('xqsp4m');
});

// --- Get leaderboard by ID ---

test('can get leaderboard by id', function () {
    MockClient::global([
        GetLeaderboardRequest::class => MockResponse::fixture('leaderboard_details'),
    ]);

    $ranking = $this->leaderboard->get('lb-generic-001');

    expect($ranking)->toBeInstanceOf(EntityRanking::class)
        ->and($ranking->leaderboard)->toBeInstanceOf(Leaderboard::class)
        ->and($ranking->items)->toContainOnlyInstancesOf(RankingItem::class);
});

test('leaderboard by id hydrates all attributes', function () {
    MockClient::global([
        GetLeaderboardRequest::class => MockResponse::fixture('leaderboard_details'),
    ]);

    $ranking = $this->leaderboard->get('lb-generic-001');
    $item = $ranking->items[0];

    expect($ranking->leaderboard->uuid)->toBe('lb-generic-001')
        ->and($ranking->leaderboard->competitionId)->toBe('comp-abc123')
        ->and($ranking->leaderboard->status)->toBe('finished')
        ->and($ranking->leaderboard->season)->toBe(2)
        ->and($ranking->leaderboard->round)->toBe(7)
        ->and($ranking->leaderboard->startingPoints)->toBe(500)
        ->and($ranking->start)->toBe(0)
        ->and($ranking->end)->toBe(1)
        ->and($item->position)->toBe(1)
        ->and($item->points)->toBe(520)
        ->and($item->winRate)->toBe(70.0)
        ->and($item->player->uuid)->toBe('a58f6134-4f31-4611-8431-b0a9630bea77');
});
