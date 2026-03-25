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

    $response = $this->leaderboard->getChampionshipLeaderboards('588ab681-e552-4617-b0e7-588713f7713c');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Leaderboard::class);
});

test('championship leaderboards hydrate all attributes', function () {
    MockClient::global([
        GetChampionshipLeaderboardsRequest::class => MockResponse::fixture('leaderboard_championship_list'),
    ]);

    $response = $this->leaderboard->getChampionshipLeaderboards('588ab681-e552-4617-b0e7-588713f7713c');

    expect($response->start)->toBeInt()
        ->and($response->end)->toBeInt();

    foreach ($response->items as $lb) {
        expect($lb->uuid)->toBeString()->not->toBeEmpty()
            ->and($lb->competitionId)->toBeString()->not->toBeEmpty()
            ->and($lb->competitionType)->toBeString()->not->toBeEmpty()
            ->and($lb->gameId)->toBeString()->not->toBeEmpty()
            ->and($lb->region)->toBeString()
            ->and($lb->leaderboardMode)->toBeString()
            ->and($lb->leaderboardName)->toBeString()->not->toBeEmpty()
            ->and($lb->leaderboardType)->toBeString()
            ->and($lb->minMatches)->toBeInt()
            ->and($lb->pointsPerDraw)->toBeInt()
            ->and($lb->pointsPerLoss)->toBeInt()
            ->and($lb->pointsPerWin)->toBeInt()
            ->and($lb->pointsType)->toBeString()
            ->and($lb->rankingBoost)->toBeInt()
            ->and($lb->rankingType)->toBeString()
            ->and($lb->round)->toBeInt()
            ->and($lb->season)->toBeInt()
            ->and($lb->startDate)->toBeInt()
            ->and($lb->endDate)->toBeInt()
            ->and($lb->startingPoints)->toBeInt()
            ->and($lb->status)->toBeString()->not->toBeEmpty()
            ->and($lb->group)->toBeInt();
    }
});

// --- Championship group ranking ---

test('can get championship group ranking', function () {
    MockClient::global([
        GetChampionshipGroupRankingRequest::class => MockResponse::fixture('leaderboard_championship_group_ranking'),
    ]);

    $ranking = $this->leaderboard->getChampionshipGroupRanking('4ee6b6af-3543-4733-be87-37efaf9f886f', 1);

    expect($ranking)->toBeInstanceOf(EntityRanking::class)
        ->and($ranking->leaderboard)->toBeInstanceOf(Leaderboard::class)
        ->and($ranking->items)->toContainOnlyInstancesOf(RankingItem::class);
});

test('championship group ranking hydrates all attributes', function () {
    MockClient::global([
        GetChampionshipGroupRankingRequest::class => MockResponse::fixture('leaderboard_championship_group_ranking'),
    ]);

    $ranking = $this->leaderboard->getChampionshipGroupRanking('4ee6b6af-3543-4733-be87-37efaf9f886f', 1);

    expect($ranking->start)->toBeInt()
        ->and($ranking->end)->toBeInt()
        ->and($ranking->leaderboard->uuid)->toBeString()->not->toBeEmpty()
        ->and($ranking->leaderboard->competitionType)->toBeString()->not->toBeEmpty();

    foreach ($ranking->items as $item) {
        expect($item->position)->toBeInt()
            ->and($item->points)->toBeInt()
            ->and($item->played)->toBeInt()
            ->and($item->won)->toBeInt()
            ->and($item->lost)->toBeInt()
            ->and($item->draw)->toBeInt()
            ->and($item->currentStreak)->toBeInt()
            ->and($item->winRate)->toBeFloat()
            ->and($item->player)->toBeInstanceOf(UserSimple::class)
            ->and($item->player->uuid)->toBeString()->not->toBeEmpty()
            ->and($item->player->nickname)->toBeString()->not->toBeEmpty()
            ->and($item->player->skillLevel)->toBeInt();
    }
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

    $response = $this->leaderboard->getHubLeaderboards('05f970ad-b6a9-4740-89d1-a9fea46f7525');

    foreach ($response->items as $lb) {
        expect($lb->uuid)->toBeString()->not->toBeEmpty()
            ->and($lb->competitionId)->toBeString()->not->toBeEmpty()
            ->and($lb->competitionType)->toBeString()->not->toBeEmpty()
            ->and($lb->gameId)->toBeString()->not->toBeEmpty()
            ->and($lb->leaderboardName)->toBeString()->not->toBeEmpty()
            ->and($lb->leaderboardType)->toBeString()
            ->and($lb->leaderboardMode)->toBeString()
            ->and($lb->status)->toBeString()->not->toBeEmpty()
            ->and($lb->season)->toBeInt()
            ->and($lb->startDate)->toBeInt()
            ->and($lb->endDate)->toBeInt()
            ->and($lb->minMatches)->toBeInt()
            ->and($lb->startingPoints)->toBeInt()
            ->and($lb->pointsPerWin)->toBeInt()
            ->and($lb->pointsPerLoss)->toBeInt()
            ->and($lb->pointsPerDraw)->toBeInt()
            ->and($lb->pointsType)->toBeString()
            ->and($lb->rankingType)->toBeString()
            ->and($lb->rankingBoost)->toBeInt();
    }
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

    expect($ranking->leaderboard->uuid)->toBeString()->not->toBeEmpty()
        ->and($ranking->leaderboard->competitionType)->toBeString()->not->toBeEmpty()
        ->and($ranking->start)->toBeInt()
        ->and($ranking->end)->toBeInt();

    foreach ($ranking->items as $item) {
        expect($item->position)->toBeInt()
            ->and($item->points)->toBeInt()
            ->and($item->played)->toBeInt()
            ->and($item->won)->toBeInt()
            ->and($item->lost)->toBeInt()
            ->and($item->currentStreak)->toBeInt()
            ->and($item->winRate)->toBeFloat()
            ->and($item->player)->toBeInstanceOf(UserSimple::class)
            ->and($item->player->uuid)->toBeString()->not->toBeEmpty()
            ->and($item->player->nickname)->toBeString()->not->toBeEmpty();
    }
});

// --- Get leaderboard by ID ---

test('can get leaderboard by id', function () {
    MockClient::global([
        GetLeaderboardRequest::class => MockResponse::fixture('leaderboard_details'),
    ]);

    $ranking = $this->leaderboard->get('69a02624260bcc6088dc548b');

    expect($ranking)->toBeInstanceOf(EntityRanking::class)
        ->and($ranking->leaderboard)->toBeInstanceOf(Leaderboard::class)
        ->and($ranking->items)->toContainOnlyInstancesOf(RankingItem::class);
});

test('leaderboard by id hydrates all attributes', function () {
    MockClient::global([
        GetLeaderboardRequest::class => MockResponse::fixture('leaderboard_details'),
    ]);

    $ranking = $this->leaderboard->get('69a02624260bcc6088dc548b');

    expect($ranking->leaderboard->uuid)->toBeString()->not->toBeEmpty()
        ->and($ranking->leaderboard->competitionId)->toBeString()->not->toBeEmpty()
        ->and($ranking->leaderboard->status)->toBeString()->not->toBeEmpty()
        ->and($ranking->start)->toBeInt()
        ->and($ranking->end)->toBeInt();

    foreach ($ranking->items as $item) {
        expect($item->position)->toBeInt()
            ->and($item->points)->toBeInt()
            ->and($item->played)->toBeInt()
            ->and($item->won)->toBeInt()
            ->and($item->lost)->toBeInt()
            ->and($item->winRate)->toBeFloat()
            ->and($item->player)->toBeInstanceOf(UserSimple::class)
            ->and($item->player->uuid)->toBeString()->not->toBeEmpty();
    }
});
