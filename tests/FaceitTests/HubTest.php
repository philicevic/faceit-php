<?php

use Philicevic\FaceitPhp\DTO\Hub\Hub;
use Philicevic\FaceitPhp\DTO\Hub\Member;
use Philicevic\FaceitPhp\DTO\Hub\Role;
use Philicevic\FaceitPhp\DTO\Hub\Rules;
use Philicevic\FaceitPhp\DTO\Player\StatsPlayer;
use Philicevic\FaceitPhp\DTO\Match\Detail\Info;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\Requests\GetHubMatchesRequest;
use Philicevic\FaceitPhp\Requests\GetHubMembersRequest;
use Philicevic\FaceitPhp\Requests\GetHubRequest;
use Philicevic\FaceitPhp\Requests\GetHubRolesRequest;
use Philicevic\FaceitPhp\Requests\GetHubRulesRequest;
use Philicevic\FaceitPhp\Requests\GetHubStatsRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->faceit = faceitMock();
});

test('can get hub', function () {
    MockClient::global([
        GetHubRequest::class => MockResponse::fixture('hub_details'),
    ]);

    $hub = $this->faceit->hub()->get('hub-uuid-1');

    expect($hub)->toBeInstanceOf(Hub::class);
});

test('hub hydrates all attributes', function () {
    MockClient::global([
        GetHubRequest::class => MockResponse::fixture('hub_details'),
    ]);

    $hub = $this->faceit->hub()->get('hub-uuid-1');

    expect($hub->uuid)->toBe('hub-uuid-1')
        ->and($hub->name)->toBe('CS2 Hub EU')
        ->and($hub->gameId)->toBe('cs2')
        ->and($hub->region)->toBe('EU')
        ->and($hub->organizerId)->toBe('org-uuid-1')
        ->and($hub->minSkillLevel)->toBe(1)
        ->and($hub->maxSkillLevel)->toBe(10)
        ->and($hub->playersJoined)->toBe(1500);
});

test('can get hub members', function () {
    MockClient::global([
        GetHubMembersRequest::class => MockResponse::fixture('hub_members'),
    ]);

    $response = $this->faceit->hub()->getMembers('hub-uuid-1');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Member::class);
});

test('hub member hydrates all attributes', function () {
    MockClient::global([
        GetHubMembersRequest::class => MockResponse::fixture('hub_members'),
    ]);

    $member = $this->faceit->hub()->getMembers('hub-uuid-1')->items[0];

    expect($member->uuid)->toBe('player-uuid-1')
        ->and($member->nickname)->toBe('ProPlayer1')
        ->and($member->roles)->toBe(['member']);
});

test('can get hub roles', function () {
    MockClient::global([
        GetHubRolesRequest::class => MockResponse::fixture('hub_roles'),
    ]);

    $response = $this->faceit->hub()->getRoles('hub-uuid-1');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Role::class);
});

test('hub role hydrates all attributes', function () {
    MockClient::global([
        GetHubRolesRequest::class => MockResponse::fixture('hub_roles'),
    ]);

    $role = $this->faceit->hub()->getRoles('hub-uuid-1')->items[0];

    expect($role->uuid)->toBe('role-uuid-1')
        ->and($role->name)->toBe('Admin')
        ->and($role->color)->toBe('#ff0000')
        ->and($role->ranking)->toBe(1)
        ->and($role->visibleOnChat)->toBeTrue();
});

test('can get hub rules', function () {
    MockClient::global([
        GetHubRulesRequest::class => MockResponse::fixture('hub_rules'),
    ]);

    $rules = $this->faceit->hub()->getRules('hub-uuid-1');

    expect($rules)->toBeInstanceOf(Rules::class);
});

test('hub rules hydrate all attributes', function () {
    MockClient::global([
        GetHubRulesRequest::class => MockResponse::fixture('hub_rules'),
    ]);

    $rules = $this->faceit->hub()->getRules('hub-uuid-1');

    expect($rules->ruleId)->toBe('rule-uuid-1')
        ->and($rules->name)->toBe('CS2 Hub Rules')
        ->and($rules->body)->toBeString()
        ->and($rules->game)->toBe('cs2');
});

test('can get hub stats', function () {
    MockClient::global([
        GetHubStatsRequest::class => MockResponse::fixture('hub_stats'),
    ]);

    $response = $this->faceit->hub()->getStats('hub-uuid-1');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(StatsPlayer::class);
});

test('hub stats player hydrates all attributes', function () {
    MockClient::global([
        GetHubStatsRequest::class => MockResponse::fixture('hub_stats'),
    ]);

    $player = $this->faceit->hub()->getStats('hub-uuid-1')->items[0];

    expect($player->uuid)->toBe('player-uuid-1')
        ->and($player->nickname)->toBe('ProPlayer1')
        ->and($player->stats)->toBeArray();
});

test('can get hub matches', function () {
    MockClient::global([
        GetHubMatchesRequest::class => MockResponse::fixture('tournament_matches'),
    ]);

    $response = $this->faceit->hub()->getMatches('hub-uuid-1');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Info::class);
});
