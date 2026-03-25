<?php

use Philicevic\FaceitPhp\DTO\Championship\Championship;
use Philicevic\FaceitPhp\DTO\Game\Game;
use Philicevic\FaceitPhp\DTO\Game\GameAssets;
use Philicevic\FaceitPhp\DTO\Hub\Hub;
use Philicevic\FaceitPhp\DTO\Organizer\Organizer;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Tournament;
use Philicevic\FaceitPhp\Enums\ChampionshipStatus;
use Philicevic\FaceitPhp\Enums\ChampionshipType;
use Philicevic\FaceitPhp\Enums\MembershipType;
use Philicevic\FaceitPhp\Enums\Region;
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
    $this->organizerId = '89ba1e87-e29b-4c98-a149-e6bcf293fa4f';
});

// --- Get organizer by name ---

test('can get organizer by name', function () {
    MockClient::global([
        GetOrganizerByNameRequest::class => MockResponse::fixture('organizer_by_name'),
    ]);

    $organizer = $this->resource->getByName('DACHCS');

    expect($organizer)->toBeInstanceOf(Organizer::class);
});

test('organizer by name hydrates all attributes', function () {
    MockClient::global([
        GetOrganizerByNameRequest::class => MockResponse::fixture('organizer_by_name'),
    ]);

    $organizer = $this->resource->getByName('DACHCS');

    expect($organizer->uuid)->toBeString()->not->toBeEmpty()
        ->and($organizer->name)->toBeString()->not->toBeEmpty()
        ->and($organizer->avatar)->toBeString()
        ->and($organizer->cover)->toBeString()
        ->and($organizer->description)->toBeString()
        ->and($organizer->faceitUrl)->toBeString()
        ->and($organizer->type)->toBeString()->not->toBeEmpty()
        ->and($organizer->followersCount)->toBeInt()
        ->and($organizer->facebook)->toBeString()
        ->and($organizer->twitter)->toBeString()
        ->and($organizer->twitch)->toBeString()
        ->and($organizer->youtube)->toBeString()
        ->and($organizer->vk)->toBeString()
        ->and($organizer->website)->toBeString();
});

// --- Get organizer by ID ---

test('can get organizer details', function () {
    MockClient::global([
        GetOrganizerRequest::class => MockResponse::fixture('organizer_details'),
    ]);

    $organizer = $this->resource->get($this->organizerId);

    expect($organizer)->toBeInstanceOf(Organizer::class);
});

test('organizer details hydrate all attributes', function () {
    MockClient::global([
        GetOrganizerRequest::class => MockResponse::fixture('organizer_details'),
    ]);

    $organizer = $this->resource->get($this->organizerId);

    expect($organizer->uuid)->toBeString()->not->toBeEmpty()
        ->and($organizer->name)->toBeString()->not->toBeEmpty()
        ->and($organizer->avatar)->toBeString()
        ->and($organizer->cover)->toBeString()
        ->and($organizer->description)->toBeString()
        ->and($organizer->faceitUrl)->toBeString()
        ->and($organizer->type)->toBeString()->not->toBeEmpty()
        ->and($organizer->followersCount)->toBeInt()
        ->and($organizer->facebook)->toBeString()
        ->and($organizer->twitter)->toBeString()
        ->and($organizer->twitch)->toBeString()
        ->and($organizer->youtube)->toBeString()
        ->and($organizer->vk)->toBeString()
        ->and($organizer->website)->toBeString();
});

// --- Get organizer championships ---

test('can get organizer championships', function () {
    MockClient::global([
        GetOrganizerChampionshipsRequest::class => MockResponse::fixture('organizer_championships'),
    ]);

    $response = $this->resource->getChampionships($this->organizerId);

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Championship::class);
});

test('organizer championships hydrate all attributes', function () {
    MockClient::global([
        GetOrganizerChampionshipsRequest::class => MockResponse::fixture('organizer_championships'),
    ]);

    $response = $this->resource->getChampionships($this->organizerId);

    expect($response->start)->toBeInt()
        ->and($response->end)->toBeInt();

    foreach ($response->items as $championship) {
        expect($championship->uuid)->toBeString()->not->toBeEmpty()
            ->and($championship->name)->toBeString()->not->toBeEmpty()
            ->and($championship->gameId)->toBeString()->not->toBeEmpty()
            ->and($championship->region)->toBeIn(Region::cases())
            ->and($championship->status)->toBeIn(ChampionshipStatus::cases())
            ->and($championship->type)->toBeIn(ChampionshipType::cases())
            ->and($championship->organizerId)->toBeString()->not->toBeEmpty()
            ->and($championship->faceitUrl)->toBeString()
            ->and($championship->avatar)->toBeString()
            ->and($championship->backgroundImage)->toBeString()
            ->and($championship->coverImage)->toBeString()
            ->and($championship->description)->toBeString()
            ->and($championship->anticheatRequired)->toBeBool()
            ->and($championship->featured)->toBeBool()
            ->and($championship->full)->toBeBool()
            ->and($championship->currentSubscriptions)->toBeInt()
            ->and($championship->slots)->toBeInt()
            ->and($championship->totalGroups)->toBeInt()
            ->and($championship->totalRounds)->toBeInt()
            ->and($championship->totalPrizes)->toBeInt()
            ->and($championship->rulesId)->toBeString()
            ->and($championship->seedingStrategy)->toBeString()
            ->and($championship->championshipStart)->toBeInt()
            ->and($championship->checkinStart)->toBeInt()
            ->and($championship->checkinClear)->toBeInt()
            ->and($championship->checkinEnabled)->toBeBool()
            ->and($championship->subscriptionStart)->toBeInt()
            ->and($championship->subscriptionEnd)->toBeInt()
            ->and($championship->subscriptionsLocked)->toBeBool();
    }
});

// --- Get organizer games ---

test('can get organizer games', function () {
    MockClient::global([
        GetOrganizerGamesRequest::class => MockResponse::fixture('organizer_games'),
    ]);

    $response = $this->resource->getGames($this->organizerId);

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Game::class);

    foreach ($response->items as $game) {
        expect($game->uuid)->toBeString()->not->toBeEmpty()
            ->and($game->shortLabel)->toBeString()->not->toBeEmpty()
            ->and($game->longLabel)->toBeString()->not->toBeEmpty()
            ->and($game->order)->toBeInt()
            ->and($game->parentGameId)->toBeString()
            ->and($game->platforms)->toBeArray()
            ->and($game->regions)->toBeArray()
            ->and($game->assets)->toBeInstanceOf(GameAssets::class);
    }
});

// --- Get organizer hubs ---

test('can get organizer hubs', function () {
    MockClient::global([
        GetOrganizerHubsRequest::class => MockResponse::fixture('organizer_hubs'),
    ]);

    $response = $this->resource->getHubs($this->organizerId);

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Hub::class);
});

test('organizer hubs hydrate all attributes', function () {
    MockClient::global([
        GetOrganizerHubsRequest::class => MockResponse::fixture('organizer_hubs'),
    ]);

    $response = $this->resource->getHubs($this->organizerId);

    expect($response->start)->toBeInt()
        ->and($response->end)->toBeInt();

    foreach ($response->items as $hub) {
        expect($hub->uuid)->toBeString()->not->toBeEmpty()
            ->and($hub->name)->toBeString()->not->toBeEmpty()
            ->and($hub->avatar)->toBeString()
            ->and($hub->backgroundImage)->toBeString()
            ->and($hub->coverImage)->toBeString()
            ->and($hub->description)->toBeString()
            ->and($hub->faceitUrl)->toBeString()
            ->and($hub->gameId)->toBeString()->not->toBeEmpty()
            ->and($hub->region)->toBeString()->not->toBeEmpty()
            ->and($hub->organizerId)->toBeString()->not->toBeEmpty()
            ->and($hub->joinPermission)->toBeString()
            ->and($hub->maxSkillLevel)->toBeInt()
            ->and($hub->minSkillLevel)->toBeInt()
            ->and($hub->playersJoined)->toBeInt()
            ->and($hub->ruleId)->toBeString()
            ->and($hub->chatRoomId)->toBeString();
    }
});

// --- Get organizer tournaments ---

test('can get organizer tournaments', function () {
    MockClient::global([
        GetOrganizerTournamentsRequest::class => MockResponse::fixture('organizer_tournaments'),
    ]);

    $response = $this->resource->getTournaments($this->organizerId);

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Tournament::class);
});

test('organizer tournaments hydrate all attributes', function () {
    MockClient::global([
        GetOrganizerTournamentsRequest::class => MockResponse::fixture('organizer_tournaments'),
    ]);

    $response = $this->resource->getTournaments($this->organizerId);

    expect($response->start)->toBeInt()
        ->and($response->end)->toBeInt();

    foreach ($response->items as $tournament) {
        expect($tournament->uuid)->toBeUuid()
            ->and($tournament->name)->toBeString()->not->toBeEmpty()
            ->and($tournament->gameId)->toBeString()->not->toBeEmpty()
            ->and($tournament->region)->toBeIn(Region::cases())
            ->and($tournament->status)->toBeIn(ChampionshipStatus::cases())
            ->and($tournament->faceitUrl)->toBeString()
            ->and($tournament->featuredImage)->toBeString()
            ->and($tournament->membershipType)->toBeIn(MembershipType::cases())
            ->and($tournament->matchType)->toBeString()
            ->and($tournament->prizeType)->toBeString()
            ->and($tournament->teamSize)->toBeInt()
            ->and($tournament->maxSkill)->toBeInt()
            ->and($tournament->minSkill)->toBeInt()
            ->and($tournament->subscriptionsCount)->toBeInt()
            ->and($tournament->numberOfPlayers)->toBeInt()
            ->and($tournament->numberOfPlayersJoined)->toBeInt()
            ->and($tournament->numberOfPlayersCheckedin)->toBeInt()
            ->and($tournament->numberOfPlayersParticipants)->toBeInt()
            ->and($tournament->startedAt)->toBeInstanceOf(DateTime::class)
            ->and($tournament->whitelistCountries)->toBeArray();
    }
});
