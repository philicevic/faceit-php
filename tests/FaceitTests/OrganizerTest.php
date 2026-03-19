<?php

use Philicevic\FaceitPhp\DTO\Championship\Championship;
use Philicevic\FaceitPhp\DTO\Game\Game;
use Philicevic\FaceitPhp\DTO\Hub\Hub;
use Philicevic\FaceitPhp\DTO\Organizer\Organizer;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
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
});

test('can get organizer by name', function () {
    MockClient::global([
        GetOrganizerByNameRequest::class => MockResponse::fixture('organizer_details'),
    ]);

    $organizer = $this->faceit->organizer()->getByName('ESL');

    expect($organizer)->toBeInstanceOf(Organizer::class);
});

test('can get organizer by id', function () {
    MockClient::global([
        GetOrganizerRequest::class => MockResponse::fixture('organizer_details'),
    ]);

    $organizer = $this->faceit->organizer()->get('org-uuid-1');

    expect($organizer)->toBeInstanceOf(Organizer::class);
});

test('organizer hydrates all attributes', function () {
    MockClient::global([
        GetOrganizerRequest::class => MockResponse::fixture('organizer_details'),
    ]);

    $organizer = $this->faceit->organizer()->get('org-uuid-1');

    expect($organizer->uuid)->toBe('org-uuid-1')
        ->and($organizer->name)->toBe('ESL')
        ->and($organizer->type)->toBe('league')
        ->and($organizer->followersCount)->toBe(50000)
        ->and($organizer->faceitUrl)->toBeString();
});

test('can get organizer championships', function () {
    MockClient::global([
        GetOrganizerChampionshipsRequest::class => MockResponse::fixture('organizer_championships'),
    ]);

    $response = $this->faceit->organizer()->getChampionships('org-uuid-1');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Championship::class);
});

test('can get organizer games', function () {
    MockClient::global([
        GetOrganizerGamesRequest::class => MockResponse::fixture('organizer_games'),
    ]);

    $response = $this->faceit->organizer()->getGames('org-uuid-1');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Game::class);
});

test('can get organizer hubs', function () {
    MockClient::global([
        GetOrganizerHubsRequest::class => MockResponse::fixture('organizer_hubs'),
    ]);

    $response = $this->faceit->organizer()->getHubs('org-uuid-1');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Hub::class);
});

test('can get organizer tournaments', function () {
    MockClient::global([
        GetOrganizerTournamentsRequest::class => MockResponse::fixture('organizer_tournaments'),
    ]);

    $response = $this->faceit->organizer()->getTournaments('org-uuid-1');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Tournament::class);
});
