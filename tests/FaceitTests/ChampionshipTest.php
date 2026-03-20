<?php

use Philicevic\FaceitPhp\DTO\Championship\Championship;
use Philicevic\FaceitPhp\DTO\Championship\Subscription;
use Philicevic\FaceitPhp\DTO\Match\Detail\Info as MatchInfo;
use Philicevic\FaceitPhp\DTO\Match\Detail\Player as MatchPlayer;
use Philicevic\FaceitPhp\DTO\Match\Detail\Team as MatchTeam;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Team\Team;
use Philicevic\FaceitPhp\Requests\GetChampionshipMatchesRequest;
use Philicevic\FaceitPhp\Requests\GetChampionshipRequest;
use Philicevic\FaceitPhp\Requests\GetChampionshipResultsRequest;
use Philicevic\FaceitPhp\Requests\GetChampionshipsRequest;
use Philicevic\FaceitPhp\Requests\GetChampionshipSubscriptionsRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->faceit = faceitMock();
    $this->resource = $this->faceit->championship();
});

// --- List championships ---

test('can list championships', function () {
    MockClient::global([
        GetChampionshipsRequest::class => MockResponse::fixture('championship_list'),
    ]);

    $response = $this->resource->list(game: 'cs2');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Championship::class);
});

test('championship list hydrates all attributes', function () {
    MockClient::global([
        GetChampionshipsRequest::class => MockResponse::fixture('championship_list'),
    ]);

    $response = $this->resource->list(game: 'cs2');
    $championship = $response->items[0];

    expect($response->start)->toBe(0)
        ->and($response->end)->toBe(1)
        ->and($championship->uuid)->toBe('champ-uuid-1')
        ->and($championship->name)->toBe('CS2 Spring Championship')
        ->and($championship->gameId)->toBe('cs2')
        ->and($championship->region)->toBe('EU')
        ->and($championship->status)->toBe('ongoing')
        ->and($championship->type)->toBe('upcoming')
        ->and($championship->organizerId)->toBe('organizer-abc123')
        ->and($championship->faceitUrl)->toBeString()
        ->and($championship->avatar)->toBeString()
        ->and($championship->backgroundImage)->toBeString()
        ->and($championship->coverImage)->toBeString()
        ->and($championship->description)->toBe('Spring championship series')
        ->and($championship->anticheatRequired)->toBeTrue()
        ->and($championship->featured)->toBeTrue()
        ->and($championship->full)->toBeFalse()
        ->and($championship->currentSubscriptions)->toBe(24)
        ->and($championship->slots)->toBe(32)
        ->and($championship->totalGroups)->toBe(4)
        ->and($championship->rulesId)->toBe('rules-123')
        ->and($championship->seedingStrategy)->toBe('manual')
        ->and($championship->championshipStart)->toBe(1710000000)
        ->and($championship->checkinStart)->toBe(1709996400)
        ->and($championship->checkinClear)->toBe(1709998200)
        ->and($championship->checkinEnabled)->toBeTrue()
        ->and($championship->subscriptionStart)->toBe(1709000000)
        ->and($championship->subscriptionEnd)->toBe(1709900000)
        ->and($championship->subscriptionsLocked)->toBeFalse();
});

// --- Get single championship ---

test('can get championship details', function () {
    MockClient::global([
        GetChampionshipRequest::class => MockResponse::fixture('championship_details'),
    ]);

    $championship = $this->resource->get('champ-uuid-1');

    expect($championship)->toBeInstanceOf(Championship::class);
});

test('championship details hydrate all attributes', function () {
    MockClient::global([
        GetChampionshipRequest::class => MockResponse::fixture('championship_details'),
    ]);

    $championship = $this->resource->get('champ-uuid-1');

    expect($championship->uuid)->toBe('champ-uuid-1')
        ->and($championship->name)->toBe('CS2 Spring Championship')
        ->and($championship->gameId)->toBe('cs2')
        ->and($championship->region)->toBe('EU')
        ->and($championship->status)->toBe('ongoing')
        ->and($championship->type)->toBe('upcoming')
        ->and($championship->organizerId)->toBe('organizer-abc123')
        ->and($championship->anticheatRequired)->toBeTrue()
        ->and($championship->featured)->toBeTrue()
        ->and($championship->full)->toBeFalse()
        ->and($championship->currentSubscriptions)->toBe(24)
        ->and($championship->slots)->toBe(32)
        ->and($championship->totalGroups)->toBe(4)
        ->and($championship->championshipStart)->toBe(1710000000)
        ->and($championship->checkinEnabled)->toBeTrue()
        ->and($championship->subscriptionsLocked)->toBeFalse();
});

// --- Get championship matches ---

test('can get championship matches', function () {
    MockClient::global([
        GetChampionshipMatchesRequest::class => MockResponse::fixture('championship_matches'),
    ]);

    $response = $this->resource->getMatches('champ-uuid-1');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(MatchInfo::class);
});

test('championship matches hydrate all attributes', function () {
    MockClient::global([
        GetChampionshipMatchesRequest::class => MockResponse::fixture('championship_matches'),
    ]);

    $response = $this->resource->getMatches('champ-uuid-1');
    $match = $response->items[0];
    $team = $match->teams[0];
    $player = $team->players[0];

    expect($response->start)->toBe(0)
        ->and($response->end)->toBe(1)
        ->and($match->uuid)->toBe('1-cc11dd22-ee33-ff44-aa55-bb6677889900')
        ->and($match->game)->toBe('cs2')
        ->and($match->region)->toBe('EU')
        ->and($match->competitionId)->toBe('champ-uuid-1')
        ->and($match->competitionType)->toBe('championship')
        ->and($match->status)->toBe('FINISHED')
        ->and($match->bestOf)->toBe(1)
        ->and($match->results->winner)->toBe('faction1')
        ->and($match->teams)->toContainOnlyInstancesOf(MatchTeam::class)
        ->and($team->players)->toContainOnlyInstancesOf(MatchPlayer::class)
        ->and($player->uuid)->toBeString()
        ->and($player->nickname)->toBeString();
});

// --- Get championship results ---

test('can get championship results', function () {
    MockClient::global([
        GetChampionshipResultsRequest::class => MockResponse::fixture('championship_results'),
    ]);

    $response = $this->resource->getResults('champ-uuid-1');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(MatchInfo::class);
});

test('championship results hydrate all attributes', function () {
    MockClient::global([
        GetChampionshipResultsRequest::class => MockResponse::fixture('championship_results'),
    ]);

    $response = $this->resource->getResults('champ-uuid-1');
    $match = $response->items[0];

    expect($match->uuid)->toBe('1-dd11ee22-ff33-aa44-bb55-cc6677889900')
        ->and($match->competitionType)->toBe('championship')
        ->and($match->results->winner)->toBe('faction2');
});

// --- Get championship subscriptions ---

test('can get championship subscriptions', function () {
    MockClient::global([
        GetChampionshipSubscriptionsRequest::class => MockResponse::fixture('championship_subscriptions'),
    ]);

    $response = $this->resource->getSubscriptions('champ-uuid-1');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Subscription::class);
});

test('championship subscriptions hydrate all attributes', function () {
    MockClient::global([
        GetChampionshipSubscriptionsRequest::class => MockResponse::fixture('championship_subscriptions'),
    ]);

    $response = $this->resource->getSubscriptions('champ-uuid-1');
    $subscription = $response->items[0];

    expect($subscription->coach)->toBe('coach-uuid-1')
        ->and($subscription->coleader)->toBe('coleader-uuid-1')
        ->and($subscription->group)->toBe(1)
        ->and($subscription->leader)->toBe('leader-uuid-1')
        ->and($subscription->roster)->toBe(['player-uuid-1', 'player-uuid-2', 'player-uuid-3', 'player-uuid-4', 'player-uuid-5'])
        ->and($subscription->status)->toBe('CHECKED_IN')
        ->and($subscription->substitutes)->toBe(['player-uuid-10', 'player-uuid-11'])
        ->and($subscription->team)->toBeInstanceOf(Team::class)
        ->and($subscription->team->uuid)->toBe('team-uuid-sub1')
        ->and($subscription->team->name)->toBe('SubscriptionTeam');
});
