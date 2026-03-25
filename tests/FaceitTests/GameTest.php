<?php

use Philicevic\FaceitPhp\DTO\Game\Game;
use Philicevic\FaceitPhp\DTO\Game\GameAssets;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\Enums\Platform;
use Philicevic\FaceitPhp\Enums\Region;
use Philicevic\FaceitPhp\Requests\GetGameRequest;
use Philicevic\FaceitPhp\Requests\GetGamesRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->faceit = faceitMock();
    $this->resource = $this->faceit->game();
});

// --- List games ---

test('can list games', function () {
    MockClient::global([
        GetGamesRequest::class => MockResponse::fixture('game_list'),
    ]);

    $response = $this->resource->list();

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Game::class)
        ->and($response->items)->not->toBeEmpty();
});

test('game list hydrates all attributes', function () {
    MockClient::global([
        GetGamesRequest::class => MockResponse::fixture('game_list'),
    ]);

    $response = $this->resource->list();

    foreach ($response->items as $game) {
        expect($game->uuid)->toBeString()->not->toBeEmpty()
            ->and($game->shortLabel)->toBeString()
            ->and($game->longLabel)->toBeString()
            ->and($game->order)->toBeNumeric()
            ->and($game->parentGameId)->toBeString()
            ->and($game->platforms)->toBeArray()->each->toBeIn(Platform::cases())
            ->and($game->regions)->toBeArray()->each->toBeIn(Region::cases())
            ->and($game->assets)->toBeInstanceOf(GameAssets::class)
            ->and($game->assets->cover)->toBeString()
            ->and($game->assets->featuredImgL)->toBeString()
            ->and($game->assets->flagImgIcon)->toBeString()
            ->and($game->assets->landingPage)->toBeString();
    }
});

// --- Get game ---

test('can get single game', function () {
    MockClient::global([
        GetGameRequest::class => MockResponse::fixture('game_details'),
    ]);

    $game = $this->resource->get('cs2');

    expect($game)->toBeInstanceOf(Game::class)
        ->and($game->uuid)->toBeString()->not->toBeEmpty()
        ->and($game->shortLabel)->toBeString()
        ->and($game->longLabel)->toBeString()
        ->and($game->order)->toBeNumeric()
        ->and($game->parentGameId)->toBeString()
        ->and($game->platforms)->toBeArray()->each->toBeIn(Platform::cases())
        ->and($game->regions)->toBeArray()->each->toBeIn(Region::cases())
        ->and($game->assets)->toBeInstanceOf(GameAssets::class)
        ->and($game->assets->cover)->toBeUrl()
        ->and($game->assets->featuredImgL)->toBeUrl()
        ->and($game->assets->flagImgIcon)->toBeUrl()
        ->and($game->assets->landingPage)->toBeUrl();
});
