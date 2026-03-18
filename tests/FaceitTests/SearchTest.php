<?php

use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Search\Championship;
use Philicevic\FaceitPhp\DTO\Search\Clan;
use Philicevic\FaceitPhp\DTO\Search\Game;
use Philicevic\FaceitPhp\DTO\Search\Hub;
use Philicevic\FaceitPhp\DTO\Search\Organizer;
use Philicevic\FaceitPhp\DTO\Search\Player;
use Philicevic\FaceitPhp\DTO\Search\Team;
use Philicevic\FaceitPhp\DTO\Search\Tournament;
use Philicevic\FaceitPhp\Enums\SearchType;
use Philicevic\FaceitPhp\Faceit;
use Philicevic\FaceitPhp\Requests\SearchChampionshipsRequest;
use Philicevic\FaceitPhp\Requests\SearchClansRequest;
use Philicevic\FaceitPhp\Requests\SearchHubsRequest;
use Philicevic\FaceitPhp\Requests\SearchOrganizersRequest;
use Philicevic\FaceitPhp\Requests\SearchPlayersRequest;
use Philicevic\FaceitPhp\Requests\SearchTeamsRequest;
use Philicevic\FaceitPhp\Requests\SearchTournamentsRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    /** @var Faceit $faceit */
    $this->faceit = faceitMock();
});

test('can search players', function () {
    MockClient::global([
        SearchPlayersRequest::class => MockResponse::fixture('search_players'),
    ]);

    $result = $this->faceit->search('xqsp4m');

    expect($result)->toBeInstanceOf(PaginatedResponse::class)
        ->and($result->items)->toContainOnlyInstancesOf(Player::class);
});

test('search players hydrate all attributes', function () {
    MockClient::global([
        SearchPlayersRequest::class => MockResponse::fixture('search_players'),
    ]);

    $result = $this->faceit->search('xqsp4m');
    $player = $result['items'][0];

    expect($player->nickname)->toBe('xqsp4m')
        ->and($player->playerId)->toBeString()
        ->and($player->avatar)->toBeString()
        ->and($player->country)->toBeString()
        ->and($player->status)->toBeString()
        ->and($player->verified)->toBeBool()
        ->and($player->games)->toContainOnlyInstancesOf(Game::class)
        ->and($player->games[0]->name)->toBe('cs2')
        ->and($player->games[0]->skillLevel)->toBe('10');
});

test('paginated response supports array access', function () {
    MockClient::global([
        SearchPlayersRequest::class => MockResponse::fixture('search_players'),
    ]);

    $result = $this->faceit->search('xqsp4m');

    expect($result[0])->toBeInstanceOf(Player::class)
        ->and($result['items'])->toContainOnlyInstancesOf(Player::class)
        ->and($result['start'])->toBe(0)
        ->and($result['end'])->toBe(1);
});

test('can search tournaments', function () {
    MockClient::global([
        SearchTournamentsRequest::class => MockResponse::fixture('search_tournaments'),
    ]);

    $result = $this->faceit->search('Weekly #1', SearchType::Tournament);
    $tournament = $result[0];

    expect($result)->toBeInstanceOf(PaginatedResponse::class)
        ->and($result->items)->toContainOnlyInstancesOf(Tournament::class)
        ->and($tournament->tournamentId)->toBe('tournament-1')
        ->and($tournament->name)->toBe('Weekly #1')
        ->and($tournament->game)->toBeString()
        ->and($tournament->region)->toBeString()
        ->and($tournament->status)->toBeString()
        ->and($tournament->prizeType)->toBeString();
});

test('can search championships', function () {
    MockClient::global([
        SearchChampionshipsRequest::class => MockResponse::fixture('search_championships'),
    ]);

    $result = $this->faceit->search('Spring', SearchType::Championship);
    $champ = $result[0];

    expect($result)->toBeInstanceOf(PaginatedResponse::class)
        ->and($result->items)->toContainOnlyInstancesOf(Championship::class)
        ->and($champ->championshipId)->toBe('champ-1')
        ->and($champ->name)->toBe('Spring Championship')
        ->and($champ->game)->toBeString()
        ->and($champ->region)->toBeString()
        ->and($champ->status)->toBeString()
        ->and($champ->type)->toBeString();
});

test('can search clans', function () {
    MockClient::global([
        SearchClansRequest::class => MockResponse::fixture('search_clans'),
    ]);

    $result = $this->faceit->search('Example', SearchType::Clan);
    $clan = $result[0];

    expect($result)->toBeInstanceOf(PaginatedResponse::class)
        ->and($result->items)->toContainOnlyInstancesOf(Clan::class)
        ->and($clan->clanId)->toBe('clan-1')
        ->and($clan->name)->toBe('Example Clan')
        ->and($clan->game)->toBeString()
        ->and($clan->avatar)->toBeString()
        ->and($clan->region)->toBeString()
        ->and($clan->membersCount)->toBeInt();
});

test('can search hubs', function () {
    MockClient::global([
        SearchHubsRequest::class => MockResponse::fixture('search_hubs'),
    ]);

    $result = $this->faceit->search('EU CS2', SearchType::Hub);
    $hub = $result[0];

    expect($result)->toBeInstanceOf(PaginatedResponse::class)
        ->and($result->items)->toContainOnlyInstancesOf(Hub::class)
        ->and($hub->hubId)->toBe('hub-1')
        ->and($hub->name)->toBe('EU CS2 Hub')
        ->and($hub->game)->toBeString()
        ->and($hub->region)->toBeString()
        ->and($hub->status)->toBeString()
        ->and($hub->slots)->toBeInt();
});

test('can search organizers', function () {
    MockClient::global([
        SearchOrganizersRequest::class => MockResponse::fixture('search_organizers'),
    ]);

    $result = $this->faceit->search('FACEIT', SearchType::Organizer);
    $organizer = $result[0];

    expect($result)->toBeInstanceOf(PaginatedResponse::class)
        ->and($result->items)->toContainOnlyInstancesOf(Organizer::class)
        ->and($organizer->organizerId)->toBe('org-1')
        ->and($organizer->name)->toBe('FACEIT')
        ->and($organizer->avatar)->toBeString()
        ->and($organizer->active)->toBeBool()
        ->and($organizer->games)->toBeArray()
        ->and($organizer->regions)->toBeArray();
});

test('can search teams', function () {
    MockClient::global([
        SearchTeamsRequest::class => MockResponse::fixture('search_teams'),
    ]);

    $result = $this->faceit->search('Alpha', SearchType::Team);
    $team = $result[0];

    expect($result)->toBeInstanceOf(PaginatedResponse::class)
        ->and($result->items)->toContainOnlyInstancesOf(Team::class)
        ->and($team->teamId)->toBe('team-1')
        ->and($team->name)->toBe('Team Alpha')
        ->and($team->game)->toBeString()
        ->and($team->avatar)->toBeString()
        ->and($team->faceitUrl)->toBeString()
        ->and($team->verified)->toBeBool();
});

test('invalid filters throw exception', function () {
    expect(fn () => $this->faceit->search('xqsp4m', filters: ['invalid_key' => 'value']))
        ->toThrow(InvalidArgumentException::class);
});
