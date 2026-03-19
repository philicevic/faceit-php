<?php

use Philicevic\FaceitPhp\DTO\Championship\Championship;
use Philicevic\FaceitPhp\DTO\Championship\Subscription;
use Philicevic\FaceitPhp\DTO\Match\Detail\Info;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\Requests\GetChampionshipMatchesRequest;
use Philicevic\FaceitPhp\Requests\GetChampionshipRequest;
use Philicevic\FaceitPhp\Requests\GetChampionshipResultsRequest;
use Philicevic\FaceitPhp\Requests\GetChampionshipsRequest;
use Philicevic\FaceitPhp\Requests\GetChampionshipSubscriptionsRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->faceit = faceitMock();
});

test('can list championships', function () {
    MockClient::global([
        GetChampionshipsRequest::class => MockResponse::fixture('championship_list'),
    ]);

    $response = $this->faceit->championship()->list('cs2');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Championship::class);
});

test('can get championship', function () {
    MockClient::global([
        GetChampionshipRequest::class => MockResponse::fixture('championship_details'),
    ]);

    $championship = $this->faceit->championship()->get('champ-uuid-1');

    expect($championship)->toBeInstanceOf(Championship::class);
});

test('championship hydrates all attributes', function () {
    MockClient::global([
        GetChampionshipRequest::class => MockResponse::fixture('championship_details'),
    ]);

    $c = $this->faceit->championship()->get('champ-uuid-1');

    expect($c->uuid)->toBe('champ-uuid-1')
        ->and($c->name)->toBe('ESL Pro League')
        ->and($c->gameId)->toBe('cs2')
        ->and($c->region)->toBe('EU')
        ->and($c->status)->toBe('ongoing')
        ->and($c->type)->toBe('championship')
        ->and($c->organizerId)->toBe('org-uuid-1')
        ->and($c->slots)->toBe(128)
        ->and($c->currentSubscriptions)->toBe(64)
        ->and($c->anticheatRequired)->toBeTrue()
        ->and($c->featured)->toBeTrue()
        ->and($c->full)->toBeFalse();
});

test('can get championship matches', function () {
    MockClient::global([
        GetChampionshipMatchesRequest::class => MockResponse::fixture('championship_matches'),
    ]);

    $response = $this->faceit->championship()->getMatches('champ-uuid-1');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Info::class);
});

test('can get championship results', function () {
    MockClient::global([
        GetChampionshipResultsRequest::class => MockResponse::fixture('championship_results'),
    ]);

    $response = $this->faceit->championship()->getResults('champ-uuid-1');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Championship::class);
});

test('can get championship subscriptions', function () {
    MockClient::global([
        GetChampionshipSubscriptionsRequest::class => MockResponse::fixture('championship_subscriptions'),
    ]);

    $response = $this->faceit->championship()->getSubscriptions('champ-uuid-1');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Subscription::class);
});

test('championship subscription hydrates all attributes', function () {
    MockClient::global([
        GetChampionshipSubscriptionsRequest::class => MockResponse::fixture('championship_subscriptions'),
    ]);

    $sub = $this->faceit->championship()->getSubscriptions('champ-uuid-1')->items[0];

    expect($sub->status)->toBe('checkedin')
        ->and($sub->leader)->toBe('player-uuid-1')
        ->and($sub->group)->toBe(1)
        ->and($sub->roster)->toBeArray();
});
