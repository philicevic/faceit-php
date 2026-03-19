<?php

use Philicevic\FaceitPhp\DTO\Game\Game;
use Philicevic\FaceitPhp\DTO\Game\Matchmaking;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\Requests\GetGameMatchmakingsRequest;
use Philicevic\FaceitPhp\Requests\GetGameRequest;
use Philicevic\FaceitPhp\Requests\GetGamesRequest;
use Philicevic\FaceitPhp\Requests\GetParentGameRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->faceit = faceitMock();
});

test('can list games', function () {
    MockClient::global([
        GetGamesRequest::class => MockResponse::fixture('game_list'),
    ]);

    $response = $this->faceit->game()->list();

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Game::class);
});

test('can get game', function () {
    MockClient::global([
        GetGameRequest::class => MockResponse::fixture('game_details'),
    ]);

    $game = $this->faceit->game()->get('cs2');

    expect($game)->toBeInstanceOf(Game::class);
});

test('game hydrates all attributes', function () {
    MockClient::global([
        GetGameRequest::class => MockResponse::fixture('game_details'),
    ]);

    $game = $this->faceit->game()->get('cs2');

    expect($game->gameId)->toBe('cs2')
        ->and($game->longLabel)->toBe('Counter-Strike 2')
        ->and($game->shortLabel)->toBe('CS2')
        ->and($game->platforms)->toBe(['PC'])
        ->and($game->regions)->toContain('EU')
        ->and($game->assets->cover)->toBeString();
});

test('can get parent game', function () {
    MockClient::global([
        GetParentGameRequest::class => MockResponse::fixture('game_details'),
    ]);

    $game = $this->faceit->game()->getParent('cs2-EU');

    expect($game)->toBeInstanceOf(Game::class);
});

test('can get game matchmakings', function () {
    MockClient::global([
        GetGameMatchmakingsRequest::class => MockResponse::fixture('game_matchmakings'),
    ]);

    $response = $this->faceit->game()->getMatchmakings('cs2');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Matchmaking::class);
});

test('game matchmaking hydrates all attributes', function () {
    MockClient::global([
        GetGameMatchmakingsRequest::class => MockResponse::fixture('game_matchmakings'),
    ]);

    $mm = $this->faceit->game()->getMatchmakings('cs2')->items[0];

    expect($mm->uuid)->toBe('mm-slim-1')
        ->and($mm->name)->toBe('Competitive EU')
        ->and($mm->game)->toBe('cs2')
        ->and($mm->region)->toBe('EU')
        ->and($mm->hasLeague)->toBeTrue();
});
