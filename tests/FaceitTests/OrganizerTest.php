<?php

use Philicevic\FaceitPhp\DTO\Championship\Championship;
use Philicevic\FaceitPhp\DTO\Organizer\Organizer;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Player\Hub;
use Philicevic\FaceitPhp\DTO\Player\Tournament;
use Philicevic\FaceitPhp\Requests\GetOrganizerByNameRequest;
use Philicevic\FaceitPhp\Requests\GetOrganizerChampionshipsRequest;
use Philicevic\FaceitPhp\Requests\GetOrganizerGamesRequest;
use Philicevic\FaceitPhp\Requests\GetOrganizerHubsRequest;
use Philicevic\FaceitPhp\Requests\GetOrganizerRequest;
use Philicevic\FaceitPhp\Requests\GetOrganizerTournamentsRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->faceit = faceitMock();
    $this->resource = $this->faceit->organizer();
});

// --- Get organizer by name ---

test('can get organizer by name', function () {
    MockClient::global([
        GetOrganizerByNameRequest::class => MockResponse::fixture('organizer_by_name'),
    ]);

    $organizer = $this->resource->getByName('FACEIT Pro League');

    expect($organizer)->toBeInstanceOf(Organizer::class);
});

test('organizer by name hydrates all attributes', function () {
    MockClient::global([
        GetOrganizerByNameRequest::class => MockResponse::fixture('organizer_by_name'),
    ]);

    $organizer = $this->resource->getByName('FACEIT Pro League');

    expect($organizer->uuid)->toBe('organizer-abc123')
        ->and($organizer->name)->toBe('FACEIT Pro League')
        ->and($organizer->avatar)->toBeString()
        ->and($organizer->cover)->toBeString()
        ->and($organizer->description)->toBe('Official FACEIT Pro League organizer')
        ->and($organizer->faceitUrl)->toBeString()
        ->and($organizer->type)->toBe('premium')
        ->and($organizer->followersCount)->toBe(15000)
        ->and($organizer->facebook)->toBe('https://facebook.com/faceitproleague')
        ->and($organizer->twitter)->toBe('https://twitter.com/faceitproleague')
        ->and($organizer->twitch)->toBe('https://twitch.tv/faceitproleague')
        ->and($organizer->youtube)->toBe('https://youtube.com/faceitproleague')
        ->and($organizer->vk)->toBe('')
        ->and($organizer->website)->toBe('https://www.faceit.com');
});

// --- Get organizer by ID ---

test('can get organizer details', function () {
    MockClient::global([
        GetOrganizerRequest::class => MockResponse::fixture('organizer_details'),
    ]);

    $organizer = $this->resource->get('organizer-abc123');

    expect($organizer)->toBeInstanceOf(Organizer::class);
});

test('organizer details hydrate all attributes', function () {
    MockClient::global([
        GetOrganizerRequest::class => MockResponse::fixture('organizer_details'),
    ]);

    $organizer = $this->resource->get('organizer-abc123');

    expect($organizer->uuid)->toBe('organizer-abc123')
        ->and($organizer->name)->toBe('FACEIT Pro League')
        ->and($organizer->type)->toBe('premium')
        ->and($organizer->followersCount)->toBe(15000)
        ->and($organizer->website)->toBe('https://www.faceit.com');
});

// --- Get organizer championships ---

test('can get organizer championships', function () {
    MockClient::global([
        GetOrganizerChampionshipsRequest::class => MockResponse::fixture('organizer_championships'),
    ]);

    $response = $this->resource->getChampionships('organizer-abc123');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Championship::class);
});

test('organizer championships hydrate all attributes', function () {
    MockClient::global([
        GetOrganizerChampionshipsRequest::class => MockResponse::fixture('organizer_championships'),
    ]);

    $response = $this->resource->getChampionships('organizer-abc123');
    $championship = $response->items[0];

    expect($response->start)->toBe(0)
        ->and($response->end)->toBe(1)
        ->and($championship->uuid)->toBe('champ-uuid-org1')
        ->and($championship->name)->toBe('Organizer Championship')
        ->and($championship->gameId)->toBe('cs2')
        ->and($championship->organizerId)->toBe('organizer-abc123')
        ->and($championship->anticheatRequired)->toBeTrue()
        ->and($championship->currentSubscriptions)->toBe(16)
        ->and($championship->slots)->toBe(32);
});

// --- Get organizer games ---

test('can get organizer games', function () {
    MockClient::global([
        GetOrganizerGamesRequest::class => MockResponse::fixture('organizer_games'),
    ]);

    $games = $this->resource->getGames('organizer-abc123');

    expect($games)->toBeArray()
        ->and($games)->toBe(['cs2', 'dota2']);
});

// --- Get organizer hubs ---

test('can get organizer hubs', function () {
    MockClient::global([
        GetOrganizerHubsRequest::class => MockResponse::fixture('organizer_hubs'),
    ]);

    $response = $this->resource->getHubs('organizer-abc123');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Hub::class);
});

test('organizer hubs hydrate all attributes', function () {
    MockClient::global([
        GetOrganizerHubsRequest::class => MockResponse::fixture('organizer_hubs'),
    ]);

    $response = $this->resource->getHubs('organizer-abc123');
    $hub = $response->items[0];

    expect($response->start)->toBe(0)
        ->and($response->end)->toBe(1)
        ->and($hub->uuid)->toBe('hub-org-1')
        ->and($hub->name)->toBe('Organizer Hub EU')
        ->and($hub->gameId)->toBe('cs2')
        ->and($hub->region)->toBe('EU')
        ->and($hub->description)->toBe('Organizer managed hub');
});

// --- Get organizer tournaments ---

test('can get organizer tournaments', function () {
    MockClient::global([
        GetOrganizerTournamentsRequest::class => MockResponse::fixture('organizer_tournaments'),
    ]);

    $response = $this->resource->getTournaments('organizer-abc123');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Tournament::class);
});

test('organizer tournaments hydrate all attributes', function () {
    MockClient::global([
        GetOrganizerTournamentsRequest::class => MockResponse::fixture('organizer_tournaments'),
    ]);

    $response = $this->resource->getTournaments('organizer-abc123');
    $tournament = $response->items[0];

    expect($response->start)->toBe(0)
        ->and($response->end)->toBe(1)
        ->and($tournament->uuid)->toBe('tournament-org-1')
        ->and($tournament->name)->toBe('Organizer Weekly Cup')
        ->and($tournament->gameId)->toBe('cs2')
        ->and($tournament->region)->toBe('EU')
        ->and($tournament->status)->toBe('finished')
        ->and($tournament->matchType)->toBe('5v5')
        ->and($tournament->prizeType)->toBe('points')
        ->and($tournament->teamSize)->toBe(5)
        ->and($tournament->subscriptionsCount)->toBe(16)
        ->and($tournament->numberOfPlayers)->toBe(80);
});
