<?php

use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Ranking\GlobalRankingItem;
use Philicevic\FaceitPhp\Requests\GetGlobalRankingRequest;
use Philicevic\FaceitPhp\Requests\GetPlayerRankingRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->faceit = faceitMock();
    $this->resource = $this->faceit->ranking();
});

// --- Global ranking ---

test('can get global ranking', function () {
    MockClient::global([
        GetGlobalRankingRequest::class => MockResponse::fixture('ranking_global'),
    ]);

    $response = $this->resource->getGlobal('cs2', 'EU');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(GlobalRankingItem::class)
        ->and(count($response->items))->toBeGreaterThan(0);
});

test('global ranking hydrates all attributes', function () {
    MockClient::global([
        GetGlobalRankingRequest::class => MockResponse::fixture('ranking_global'),
    ]);

    $response = $this->resource->getGlobal('cs2', 'EU');

    foreach ($response->items as $player) {
        expect($player->uuid)->toBeString()->not->toBeEmpty()
            ->and($player->nickname)->toBeString()->not->toBeEmpty()
            ->and($player->country)->toBeString()->not->toBeEmpty()
            ->and($player->faceitElo)->toBeInt()
            ->and($player->gameSkillLevel)->toBeInt()
            ->and($player->position)->toBeInt();
    }
});

// --- Player ranking ---

test('can get player ranking', function () {
    MockClient::global([
        GetPlayerRankingRequest::class => MockResponse::fixture('ranking_player'),
    ]);

    $response = $this->resource->getPlayer('cs2', 'EU', 'a58f6134-4f31-4611-8431-b0a9630bea77');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(GlobalRankingItem::class)
        ->and(count($response->items))->toBeGreaterThan(0);
});

test('player ranking hydrates all attributes', function () {
    MockClient::global([
        GetPlayerRankingRequest::class => MockResponse::fixture('ranking_player'),
    ]);

    $response = $this->resource->getPlayer('cs2', 'EU', 'a58f6134-4f31-4611-8431-b0a9630bea77');

    foreach ($response->items as $player) {
        expect($player->uuid)->toBeString()->not->toBeEmpty()
            ->and($player->nickname)->toBeString()->not->toBeEmpty()
            ->and($player->country)->toBeString()->not->toBeEmpty()
            ->and($player->faceitElo)->toBeInt()
            ->and($player->gameSkillLevel)->toBeInt()
            ->and($player->position)->toBeInt();
    }
});
