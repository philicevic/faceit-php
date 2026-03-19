<?php

use Philicevic\FaceitPhp\DTO\League\Division;
use Philicevic\FaceitPhp\DTO\League\League;
use Philicevic\FaceitPhp\DTO\League\PlayerInLeague;
use Philicevic\FaceitPhp\DTO\League\Season;
use Philicevic\FaceitPhp\DTO\League\SeasonDetailed;
use Philicevic\FaceitPhp\Requests\GetLeagueRequest;
use Philicevic\FaceitPhp\Requests\GetLeagueSeasonPlayerRequest;
use Philicevic\FaceitPhp\Requests\GetLeagueSeasonRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->faceit = faceitMock();
});

test('can get league', function () {
    MockClient::global([
        GetLeagueRequest::class => MockResponse::fixture('league_details'),
    ]);

    $league = $this->faceit->league()->get('league-uuid-1');

    expect($league)->toBeInstanceOf(League::class)
        ->and($league->divisions)->toContainOnlyInstancesOf(Division::class);
});

test('league hydrates all attributes', function () {
    MockClient::global([
        GetLeagueRequest::class => MockResponse::fixture('league_details'),
    ]);

    $league = $this->faceit->league()->get('league-uuid-1');

    expect($league->uuid)->toBe('league-uuid-1')
        ->and($league->game)->toBe('cs2')
        ->and($league->region)->toBe('EU')
        ->and($league->minMatches)->toBe(10)
        ->and($league->divisions[0]->name)->toBe('Diamond')
        ->and($league->divisions[0]->configType)->toBe('classic');
});

test('can get league season', function () {
    MockClient::global([
        GetLeagueSeasonRequest::class => MockResponse::fixture('league_season'),
    ]);

    $season = $this->faceit->league()->getSeason('league-uuid-1', 'season-3');

    expect($season)->toBeInstanceOf(SeasonDetailed::class)
        ->and($season->season)->toBeInstanceOf(Season::class)
        ->and($season->divisions)->toContainOnlyInstancesOf(Division::class);
});

test('league season hydrates all attributes', function () {
    MockClient::global([
        GetLeagueSeasonRequest::class => MockResponse::fixture('league_season'),
    ]);

    $season = $this->faceit->league()->getSeason('league-uuid-1', 'season-3');

    expect($season->season->number)->toBe(3)
        ->and($season->season->startDate)->toBeString()
        ->and($season->season->placementMatchCount)->toBe(5);
});

test('can get league season player', function () {
    MockClient::global([
        GetLeagueSeasonPlayerRequest::class => MockResponse::fixture('league_season_player'),
    ]);

    $player = $this->faceit->league()->getSeasonPlayer('league-uuid-1', 'season-3', 'player-uuid-1');

    expect($player)->toBeInstanceOf(PlayerInLeague::class);
});

test('league season player hydrates all attributes', function () {
    MockClient::global([
        GetLeagueSeasonPlayerRequest::class => MockResponse::fixture('league_season_player'),
    ]);

    $player = $this->faceit->league()->getSeasonPlayer('league-uuid-1', 'season-3', 'player-uuid-1');

    expect($player->divisionName)->toBe('Diamond')
        ->and($player->divisionTier)->toBe('I')
        ->and($player->leaderboardId)->toBe('lb-1')
        ->and($player->points)->toBe(1500)
        ->and($player->position)->toBe(42);
});
