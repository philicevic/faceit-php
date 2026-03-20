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
        ->and($response->items)->toHaveCount(2);
});

test('global ranking hydrates all attributes', function () {
    MockClient::global([
        GetGlobalRankingRequest::class => MockResponse::fixture('ranking_global'),
    ]);

    $response = $this->resource->getGlobal('cs2', 'EU');
    $player = $response->items[0];

    expect($player->uuid)->toBe('aaa-111')
        ->and($player->nickname)->toBe('s1mple')
        ->and($player->country)->toBe('UA')
        ->and($player->faceitElo)->toBe(4321)
        ->and($player->gameSkillLevel)->toBe(10)
        ->and($player->position)->toBe(1);
});

// --- Player ranking ---

test('can get player ranking', function () {
    MockClient::global([
        GetPlayerRankingRequest::class => MockResponse::fixture('ranking_player'),
    ]);

    $response = $this->resource->getPlayer('cs2', 'EU', 'a58f6134-4f31-4611-8431-b0a9630bea77');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(GlobalRankingItem::class)
        ->and($response->items)->toHaveCount(1);
});

test('player ranking hydrates all attributes', function () {
    MockClient::global([
        GetPlayerRankingRequest::class => MockResponse::fixture('ranking_player'),
    ]);

    $response = $this->resource->getPlayer('cs2', 'EU', 'a58f6134-4f31-4611-8431-b0a9630bea77');
    $player = $response->items[0];

    expect($player->uuid)->toBe('a58f6134-4f31-4611-8431-b0a9630bea77')
        ->and($player->nickname)->toBe('xqsp4m')
        ->and($player->country)->toBe('DE')
        ->and($player->faceitElo)->toBe(1850)
        ->and($player->gameSkillLevel)->toBe(8)
        ->and($player->position)->toBe(12345);
});
