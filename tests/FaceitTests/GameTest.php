<?php

use Philicevic\FaceitPhp\DTO\Game\Game;
use Philicevic\FaceitPhp\DTO\Game\GameAssets;
use Philicevic\FaceitPhp\DTO\Game\MatchmakingSummary;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\Requests\GetGameMatchmakingsRequest;
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
        ->and($response->items)->toContainOnlyInstancesOf(Game::class);
});

test('game list hydrates all attributes', function () {
    MockClient::global([
        GetGamesRequest::class => MockResponse::fixture('game_list'),
    ]);

    $response = $this->resource->list();
    $game = $response->items[0];

    expect($game->uuid)->toBe('cs2')
        ->and($game->shortLabel)->toBe('CS2')
        ->and($game->longLabel)->toBe('Counter-Strike 2')
        ->and($game->order)->toBe(1)
        ->and($game->parentGameId)->toBe('csgo')
        ->and($game->platforms)->toBe(['steam'])
        ->and($game->regions)->toContain('EU', 'US')
        ->and($game->assets)->toBeInstanceOf(GameAssets::class)
        ->and($game->assets->cover)->toBe('https://cdn.faceit.com/games/cs2/cover.jpg')
        ->and($game->assets->featuredImgL)->toBe('https://cdn.faceit.com/games/cs2/featured_l.jpg')
        ->and($game->assets->flagImgIcon)->toBe('https://cdn.faceit.com/games/cs2/flag_icon.png')
        ->and($game->assets->landingPage)->toBe('https://www.faceit.com/en/cs2');
});

// --- Get game ---

test('can get single game', function () {
    MockClient::global([
        GetGameRequest::class => MockResponse::fixture('game_details'),
    ]);

    $game = $this->resource->get('cs2');

    expect($game)->toBeInstanceOf(Game::class)
        ->and($game->uuid)->toBe('cs2')
        ->and($game->longLabel)->toBe('Counter-Strike 2');
});

// --- Get game matchmakings ---

test('can get game matchmakings', function () {
    MockClient::global([
        GetGameMatchmakingsRequest::class => MockResponse::fixture('game_matchmakings'),
    ]);

    $response = $this->resource->getMatchmakings('cs2');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(MatchmakingSummary::class);
});

test('game matchmaking summary hydrates all attributes', function () {
    MockClient::global([
        GetGameMatchmakingsRequest::class => MockResponse::fixture('game_matchmakings'),
    ]);

    $response = $this->resource->getMatchmakings('cs2', 'EU');
    $mm = $response->items[0];

    expect($mm->uuid)->toBe('mm-abc123')
        ->and($mm->name)->toBe('CS2 5v5 Premium')
        ->and($mm->game)->toBe('cs2')
        ->and($mm->region)->toBe('EU')
        ->and($mm->hasLeague)->toBeTrue();
});
