<?php

use Philicevic\FaceitPhp\DTO\Championship\Championship;
use Philicevic\FaceitPhp\DTO\Championship\Results\Bounds;
use Philicevic\FaceitPhp\DTO\Championship\Results\Group;
use Philicevic\FaceitPhp\DTO\Championship\Results\Placement;
use Philicevic\FaceitPhp\DTO\Championship\Subscription;
use Philicevic\FaceitPhp\DTO\Match\Detail\Info as MatchInfo;
use Philicevic\FaceitPhp\DTO\Match\Detail\Player as MatchPlayer;
use Philicevic\FaceitPhp\DTO\Match\Detail\Team as MatchTeam;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Team\Team;
use Philicevic\FaceitPhp\Enums\ChampionshipStatus;
use Philicevic\FaceitPhp\Enums\ChampionshipType;
use Philicevic\FaceitPhp\Enums\CompetitionType;
use Philicevic\FaceitPhp\Enums\MatchStatus;
use Philicevic\FaceitPhp\Enums\PlacementType;
use Philicevic\FaceitPhp\Enums\Region;
use Philicevic\FaceitPhp\Enums\SubscriptionStatus;
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
    $this->championship = '588ab681-e552-4617-b0e7-588713f7713c';
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

test('can list championships with limit', function () {
    MockClient::global([
        GetChampionshipsRequest::class => MockResponse::fixture('championship_list_limited'),
    ]);

    $response = $this->resource->list(game: 'cs2', limit: 100);

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toHaveCount(100);
});

test('championship list hydrates all attributes', function () {
    MockClient::global([
        GetChampionshipsRequest::class => MockResponse::fixture('championship_list_limited'),
    ]);

    $response = $this->resource->list(game: 'cs2', limit: 100);

    expect($response->start)->toBe(0)
        ->and($response->end)->toBe(100);

    foreach ($response->items as $championship) {
        expect($championship->uuid)->toBeString()->not()->toBeEmpty()
            ->and($championship->name)->toBeString()->not()->toBeEmpty()
            ->and($championship->gameId)->toBe('cs2')
            ->and($championship->region)->toBeIn(Region::cases())
            ->and($championship->status)->toBeIn(ChampionshipStatus::cases())
            ->and($championship->type)->toBeIn(ChampionshipType::cases())
            ->and($championship->organizerId)->toBeString()->not()->toBeEmpty()
            ->and($championship->faceitUrl)->toBeString()->not()->toBeEmpty()
            ->and($championship->avatar)->toBeString()
            ->and($championship->backgroundImage)->toBeString()
            ->and($championship->coverImage)->toBeString()
            ->and($championship->description)->toBeString()
            ->and($championship->anticheatRequired)->toBeBool()
            ->and($championship->featured)->toBeBool()
            ->and($championship->full)->toBeBool()
            ->and($championship->currentSubscriptions)->toBeNumeric()
            ->and($championship->slots)->toBeNumeric()
            ->and($championship->totalGroups)->toBeNumeric()
            ->and($championship->rulesId)->toBeString()
            ->and($championship->seedingStrategy)->toBeIn(['manual', 'uniformGroupDistribution', 'doubleEliminationDistribution'])
            ->and($championship->championshipStart)->toBeNumeric()
            ->and($championship->checkinStart)->toBeNumeric()
            ->and($championship->checkinClear)->toBeNumeric()
            ->and($championship->checkinEnabled)->toBeBool()
            ->and($championship->subscriptionStart)->toBeNumeric()
            ->and($championship->subscriptionEnd)->toBeNumeric()
            ->and($championship->subscriptionsLocked)->toBeBool();
    }
});

// --- Get single championship ---

test('can get championship details', function () {
    MockClient::global([
        GetChampionshipRequest::class => MockResponse::fixture('championship_details'),
    ]);

    $championship = $this->resource->get($this->championship);

    expect($championship)->toBeInstanceOf(Championship::class);
});

test('championship details hydrate all attributes', function () {
    MockClient::global([
        GetChampionshipRequest::class => MockResponse::fixture('championship_details'),
    ]);

    $championship = $this->resource->get($this->championship);

    expect($championship->uuid)->toBe('4af3f365-8333-418c-8677-eba68d63fffb')
        ->and($championship->name)->toBeString()->not()->toBeEmpty()
        ->and($championship->gameId)->toBe('cs2')
        ->and($championship->region)->toBeIn(Region::cases())
        ->and($championship->status)->toBeIn(ChampionshipStatus::cases())
        ->and($championship->type)->toBeIn(ChampionshipType::cases())
        ->and($championship->organizerId)->toBeString()->not()->toBeEmpty()
        ->and($championship->anticheatRequired)->toBeBool()
        ->and($championship->featured)->toBeBool()
        ->and($championship->full)->toBeBool()
        ->and($championship->currentSubscriptions)->toBeNumeric()
        ->and($championship->slots)->toBeNumeric()
        ->and($championship->totalGroups)->toBeNumeric()
        ->and($championship->championshipStart)->toBeNumeric()
        ->and($championship->checkinEnabled)->toBeBool()
        ->and($championship->subscriptionsLocked)->toBeBool();
});

// --- Get championship matches ---

test('can get championship matches', function () {
    MockClient::global([
        GetChampionshipMatchesRequest::class => MockResponse::fixture('championship_matches'),
    ]);

    $response = $this->resource->getMatches($this->championship);

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(MatchInfo::class);
});

test('championship matches hydrate all attributes', closure: function () {
    MockClient::global([
        GetChampionshipMatchesRequest::class => MockResponse::fixture('championship_matches'),
    ]);

    $response = $this->resource->getMatches($this->championship);

    expect($response->start)->toBe(0)
        ->and($response->end)->toBe(20);

    foreach ($response->items as $match) {
        expect($match->uuid)->toBeString()->not()->toBeEmpty()
            ->and($match->game)->toBe('cs2')
            ->and($match->region)->toBeIn(Region::cases())
            ->and($match->competitionId)->toBeString()->not()->toBeEmpty()
            ->and($match->competitionType)->toBe(CompetitionType::Championship)
            ->and($match->status)->toBeIn(MatchStatus::cases())
            ->and($match->bestOf)->toBeNumeric()
            ->and($match->teams)->toContainOnlyInstancesOf(MatchTeam::class);

        foreach ($match->teams as $team) {
            expect($team->players)->toContainOnlyInstancesOf(MatchPlayer::class);

            foreach ($team->players as $player) {
                expect($team->players)->toContainOnlyInstancesOf(MatchPlayer::class)
                    ->and($player->uuid)->toBeString()
                    ->and($player->nickname)->toBeString();
            }
        }
    }
});

// --- Get championship results ---

test('can get championship results', function () {
    MockClient::global([
        GetChampionshipResultsRequest::class => MockResponse::fixture('championship_results'),
    ]);

    $response = $this->resource->getResults($this->championship);

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Group::class);
});

test('placement can be empty', function () {
    $placement = Placement::fromArray([
        'id' => '',
        'name' => '',
        'type' => '',
    ]);
    $filledPlacement = Placement::fromArray([
        'id' => 'fake-id',
        'name' => 'fake-name',
        'type' => 'team',
    ]);

    expect($placement->isEmpty())->toBeTrue()
        ->and($filledPlacement->isEmpty())->toBeFalse();
});

test('championship results hydrate all attributes', function () {
    MockClient::global([
        GetChampionshipResultsRequest::class => MockResponse::fixture('championship_results'),
    ]);

    $response = $this->resource->getResults($this->championship);
    $match = $response->items[0];

    foreach ($response->items as $group) {
        expect($group->bounds)->toBeInstanceOf(Bounds::class)
            ->and($group->bounds->left)->toBeNumeric()
            ->and($group->bounds->right)->toBeNumeric()
            ->and($group->placements)->toBeArray()
            ->and($group->placements)->toContainOnlyInstancesOf(Placement::class);

        foreach ($group->placements as $placement) {
            expect($placement->uuid)
                ->when($placement->isEmpty(), fn ($id) => $id->toBeEmpty())
                ->when(! $placement->isEmpty(), fn ($id) => $id->toBeString()->not->toBeEmpty())
                ->and($placement->name)
                ->when($placement->isEmpty(), fn ($name) => $name->toBeEmpty())
                ->when(! $placement->isEmpty(), fn ($name) => $name->toBeString()->not()->toBeEmpty())
                ->and($placement->type)
                ->when($placement->isEmpty(), fn ($type) => $type->toBeNull())
                ->when(! $placement->isEmpty(), fn ($type) => $type->toBeIn(PlacementType::cases()));
        }
    }
});

// --- Get championship subscriptions ---

test('can get championship subscriptions', function () {
    MockClient::global([
        GetChampionshipSubscriptionsRequest::class => MockResponse::fixture('championship_subscriptions'),
    ]);

    $response = $this->resource->getSubscriptions($this->championship);

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Subscription::class);
});

test('championship subscriptions hydrate all attributes', function () {
    MockClient::global([
        GetChampionshipSubscriptionsRequest::class => MockResponse::fixture('championship_subscriptions'),
    ]);

    $response = $this->resource->getSubscriptions($this->championship);
    $subscription = $response->items[0];

    expect($subscription->coach)->toBeString()
        ->and($subscription->coleader)->toBeString()
        ->and($subscription->group)->toBeNumeric()
        ->and($subscription->leader)->toBeString()->not->toBeEmpty()
        ->and($subscription->roster)->each->toBeString()->not->toBeEmpty()
        ->and($subscription->status)->toBeIn(SubscriptionStatus::cases())
        ->and($subscription->substitutes)->each->toBeString()->not->toBeEmpty()
        ->and($subscription->team)->toBeInstanceOf(Team::class)
        ->and($subscription->team->uuid)->toBeString()->not->toBeEmpty()
        ->and($subscription->team->name)->toBeString()->not->toBeEmpty();
});
