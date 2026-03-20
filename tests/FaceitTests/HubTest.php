<?php

use Philicevic\FaceitPhp\DTO\Hub\Hub;
use Philicevic\FaceitPhp\DTO\Hub\HubStats;
use Philicevic\FaceitPhp\DTO\Hub\HubStatsPlayer;
use Philicevic\FaceitPhp\DTO\Hub\Member;
use Philicevic\FaceitPhp\DTO\Hub\Role;
use Philicevic\FaceitPhp\DTO\Hub\Rules;
use Philicevic\FaceitPhp\DTO\Match\Detail\Info as MatchInfo;
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
    $this->hub = $this->faceit->hub();
});

// --- Get hub details ---

test('can get hub details', function () {
    MockClient::global([
        GetHubRequest::class => MockResponse::fixture('hub_details'),
    ]);

    $hub = $this->hub->get('05f970ad-b6a9-4740-89d1-a9fea46f7525');

    expect($hub)->toBeInstanceOf(Hub::class)
        ->and($hub->uuid)->toBe('05f970ad-b6a9-4740-89d1-a9fea46f7525');
});

test('hub details hydrate all attributes', function () {
    MockClient::global([
        GetHubRequest::class => MockResponse::fixture('hub_details'),
    ]);

    $hub = $this->hub->get('05f970ad-b6a9-4740-89d1-a9fea46f7525');

    expect($hub->uuid)->toBe('05f970ad-b6a9-4740-89d1-a9fea46f7525')
        ->and($hub->name)->toBe('CS2 EU Hub')
        ->and($hub->avatar)->toBeString()
        ->and($hub->backgroundImage)->toBeString()
        ->and($hub->coverImage)->toBeString()
        ->and($hub->description)->toBe('The best CS2 hub in Europe')
        ->and($hub->faceitUrl)->toBeString()
        ->and($hub->gameId)->toBe('cs2')
        ->and($hub->region)->toBe('EU')
        ->and($hub->organizerId)->toBe('organizer-abc123')
        ->and($hub->joinPermission)->toBe('open')
        ->and($hub->maxSkillLevel)->toBe(10)
        ->and($hub->minSkillLevel)->toBe(1)
        ->and($hub->playersJoined)->toBe(4523)
        ->and($hub->ruleId)->toBe('rule-abc123')
        ->and($hub->chatRoomId)->toBe('hub-05f970ad-b6a9-4740-89d1-a9fea46f7525');
});

// --- Get hub matches ---

test('can get hub matches', function () {
    MockClient::global([
        GetHubMatchesRequest::class => MockResponse::fixture('hub_matches'),
    ]);

    $response = $this->hub->getMatches('05f970ad-b6a9-4740-89d1-a9fea46f7525');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(MatchInfo::class);
});

test('hub matches hydrate all attributes', function () {
    MockClient::global([
        GetHubMatchesRequest::class => MockResponse::fixture('hub_matches'),
    ]);

    $response = $this->hub->getMatches('05f970ad-b6a9-4740-89d1-a9fea46f7525');
    $match = $response->items[0];

    expect($response->start)->toBe(0)
        ->and($response->end)->toBe(1)
        ->and($match->uuid)->toBe('1-abc12345-def6-7890-abcd-ef1234567890')
        ->and($match->game)->toBe('cs2')
        ->and($match->region)->toBe('EU')
        ->and($match->competitionId)->toBe('05f970ad-b6a9-4740-89d1-a9fea46f7525')
        ->and($match->competitionType)->toBe('hub')
        ->and($match->competitionName)->toBe('CS2 EU Hub')
        ->and($match->status)->toBe('FINISHED')
        ->and($match->bestOf)->toBe(1)
        ->and($match->startedAt)->toBeInstanceOf(DateTime::class)
        ->and($match->finishedAt)->toBeInstanceOf(DateTime::class)
        ->and($match->faceitUrl)->toBeString()
        ->and($match->results->winner)->toBe('faction1');
});

// --- Get hub members ---

test('can get hub members', function () {
    MockClient::global([
        GetHubMembersRequest::class => MockResponse::fixture('hub_members'),
    ]);

    $response = $this->hub->getMembers('05f970ad-b6a9-4740-89d1-a9fea46f7525');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Member::class);
});

test('hub members hydrate all attributes', function () {
    MockClient::global([
        GetHubMembersRequest::class => MockResponse::fixture('hub_members'),
    ]);

    $member = $this->hub->getMembers('05f970ad-b6a9-4740-89d1-a9fea46f7525')->items[0];

    expect($member->uuid)->toBe('a58f6134-4f31-4611-8431-b0a9630bea77')
        ->and($member->nickname)->toBe('xqsp4m')
        ->and($member->avatar)->toBeString()
        ->and($member->faceitUrl)->toBeString()
        ->and($member->roles)->toBe(['admin', 'moderator']);
});

// --- Get hub roles ---

test('can get hub roles', function () {
    MockClient::global([
        GetHubRolesRequest::class => MockResponse::fixture('hub_roles'),
    ]);

    $response = $this->hub->getRoles('05f970ad-b6a9-4740-89d1-a9fea46f7525');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Role::class);
});

test('hub roles hydrate all attributes', function () {
    MockClient::global([
        GetHubRolesRequest::class => MockResponse::fixture('hub_roles'),
    ]);

    $role = $this->hub->getRoles('05f970ad-b6a9-4740-89d1-a9fea46f7525')->items[0];

    expect($role->uuid)->toBe('role-admin-123')
        ->and($role->name)->toBe('Admin')
        ->and($role->color)->toBe('#FF0000')
        ->and($role->ranking)->toBe(1)
        ->and($role->visibleOnChat)->toBeTrue();
});

// --- Get hub rules ---

test('can get hub rules', function () {
    MockClient::global([
        GetHubRulesRequest::class => MockResponse::fixture('hub_rules'),
    ]);

    $rules = $this->hub->getRules('05f970ad-b6a9-4740-89d1-a9fea46f7525');

    expect($rules)->toBeInstanceOf(Rules::class);
});

test('hub rules hydrate all attributes', function () {
    MockClient::global([
        GetHubRulesRequest::class => MockResponse::fixture('hub_rules'),
    ]);

    $rules = $this->hub->getRules('05f970ad-b6a9-4740-89d1-a9fea46f7525');

    expect($rules->uuid)->toBe('rule-abc123')
        ->and($rules->name)->toBe('CS2 EU Hub Rules')
        ->and($rules->body)->toBeString()
        ->and($rules->game)->toBe('cs2')
        ->and($rules->organizer)->toBe('FACEIT');
});

// --- Get hub stats ---

test('can get hub stats', function () {
    MockClient::global([
        GetHubStatsRequest::class => MockResponse::fixture('hub_stats'),
    ]);

    $stats = $this->hub->getStats('05f970ad-b6a9-4740-89d1-a9fea46f7525');

    expect($stats)->toBeInstanceOf(HubStats::class)
        ->and($stats->players)->toContainOnlyInstancesOf(HubStatsPlayer::class);
});

test('hub stats hydrate all attributes', function () {
    MockClient::global([
        GetHubStatsRequest::class => MockResponse::fixture('hub_stats'),
    ]);

    $stats = $this->hub->getStats('05f970ad-b6a9-4740-89d1-a9fea46f7525');
    $player = $stats->players[0];

    expect($stats->gameId)->toBe('cs2')
        ->and($stats->players)->toHaveCount(2)
        ->and($player->uuid)->toBe('a58f6134-4f31-4611-8431-b0a9630bea77')
        ->and($player->nickname)->toBe('xqsp4m')
        ->and($player->stats)->toHaveKey('Matches')
        ->and($player->stats)->toHaveKey('Average K/D Ratio')
        ->and($player->stats['Matches'])->toBe('42');
});
