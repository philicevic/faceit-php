<?php

use Philicevic\FaceitPhp\DTO\Hub\Hub;
use Philicevic\FaceitPhp\DTO\Hub\HubStats;
use Philicevic\FaceitPhp\DTO\Hub\HubStatsPlayer;
use Philicevic\FaceitPhp\DTO\Hub\Member;
use Philicevic\FaceitPhp\DTO\Hub\Role;
use Philicevic\FaceitPhp\DTO\Hub\Rules;
use Philicevic\FaceitPhp\DTO\Match\Detail\Info as MatchInfo;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\Enums\CompetitionType;
use Philicevic\FaceitPhp\Enums\MatchStatus;
use Philicevic\FaceitPhp\Enums\Region;
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
    $this->hubId = '05f970ad-b6a9-4740-89d1-a9fea46f7525';
});

// --- Get hub details ---

test('can get hub details', function () {
    MockClient::global([
        GetHubRequest::class => MockResponse::fixture('hub_details'),
    ]);

    $hub = $this->hub->get($this->hubId);

    expect($hub)->toBeInstanceOf(Hub::class)
        ->and($hub->uuid)->toBe($this->hubId);
});

test('hub details hydrate all attributes', function () {
    MockClient::global([
        GetHubRequest::class => MockResponse::fixture('hub_details'),
    ]);

    $hub = $this->hub->get($this->hubId);

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
});

// --- Get hub matches ---

test('can get hub matches', function () {
    MockClient::global([
        GetHubMatchesRequest::class => MockResponse::fixture('hub_matches'),
    ]);

    $response = $this->hub->getMatches($this->hubId);

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(MatchInfo::class);
});

test('hub matches hydrate all attributes', function () {
    MockClient::global([
        GetHubMatchesRequest::class => MockResponse::fixture('hub_matches'),
    ]);

    $response = $this->hub->getMatches($this->hubId);

    expect($response->start)->toBeInt()
        ->and($response->end)->toBeInt();

    foreach ($response->items as $match) {
        expect($match->uuid)->toBeString()->not->toBeEmpty()
            ->and($match->game)->toBeString()->not->toBeEmpty()
            ->and($match->region)->toBeIn(Region::cases())
            ->and($match->competitionId)->toBeString()->not->toBeEmpty()
            ->and($match->competitionType)->toBeIn(CompetitionType::cases())
            ->and($match->competitionName)->toBeString()->not->toBeEmpty()
            ->and($match->status)->toBeIn(MatchStatus::cases())
            ->and($match->bestOf)->toBeInt()
            ->and($match->organizerId)->toBeString()->not->toBeEmpty()
            ->and($match->faceitUrl)->toBeString()
            ->and($match->version)->toBeInt()
            ->and($match->calculateElo)->toBeBool()
            ->and($match->chatRoomId)->toBeString()
            ->and($match->demoUrl)->toBeArray()
            ->and($match->teams)->toBeArray();
    }
});

// --- Get hub members ---

test('can get hub members', function () {
    MockClient::global([
        GetHubMembersRequest::class => MockResponse::fixture('hub_members'),
    ]);

    $response = $this->hub->getMembers($this->hubId);

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Member::class);
});

test('hub members hydrate all attributes', function () {
    MockClient::global([
        GetHubMembersRequest::class => MockResponse::fixture('hub_members'),
    ]);

    $response = $this->hub->getMembers($this->hubId);

    foreach ($response->items as $member) {
        expect($member->uuid)->toBeString()->not->toBeEmpty()
            ->and($member->nickname)->toBeString()->not->toBeEmpty()
            ->and($member->avatar)->toBeString()
            ->and($member->faceitUrl)->toBeString()
            ->and($member->roles)->toBeArray();
    }
});

// --- Get hub roles ---

test('can get hub roles', function () {
    MockClient::global([
        GetHubRolesRequest::class => MockResponse::fixture('hub_roles'),
    ]);

    $response = $this->hub->getRoles($this->hubId);

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Role::class);
});

test('hub roles hydrate all attributes', function () {
    MockClient::global([
        GetHubRolesRequest::class => MockResponse::fixture('hub_roles'),
    ]);

    $response = $this->hub->getRoles($this->hubId);

    foreach ($response->items as $role) {
        expect($role->uuid)->toBeString()->not->toBeEmpty()
            ->and($role->name)->toBeString()->not->toBeEmpty()
            ->and($role->color)->toBeString()->not->toBeEmpty()
            ->and($role->ranking)->toBeInt()
            ->and($role->visibleOnChat)->toBeBool();
    }
});

// --- Get hub rules ---

test('can get hub rules', function () {
    MockClient::global([
        GetHubRulesRequest::class => MockResponse::fixture('hub_rules'),
    ]);

    $rules = $this->hub->getRules($this->hubId);

    expect($rules)->toBeInstanceOf(Rules::class);
});

test('hub rules hydrate all attributes', function () {
    MockClient::global([
        GetHubRulesRequest::class => MockResponse::fixture('hub_rules'),
    ]);

    $rules = $this->hub->getRules($this->hubId);

    expect($rules->uuid)->toBeString()->not->toBeEmpty()
        ->and($rules->name)->toBeString()->not->toBeEmpty()
        ->and($rules->body)->toBeString()->not->toBeEmpty()
        ->and($rules->game)->toBeString()->not->toBeEmpty()
        ->and($rules->organizer)->toBeString()->not->toBeEmpty();
});

// --- Get hub stats ---

test('can get hub stats', function () {
    MockClient::global([
        GetHubStatsRequest::class => MockResponse::fixture('hub_stats'),
    ]);

    $stats = $this->hub->getStats($this->hubId);

    expect($stats)->toBeInstanceOf(HubStats::class)
        ->and($stats->players)->toContainOnlyInstancesOf(HubStatsPlayer::class);
});

test('hub stats hydrate all attributes', function () {
    MockClient::global([
        GetHubStatsRequest::class => MockResponse::fixture('hub_stats'),
    ]);

    $stats = $this->hub->getStats($this->hubId);

    expect($stats->gameId)->toBeString()->not->toBeEmpty()
        ->and($stats->players)->not->toBeEmpty();

    foreach ($stats->players as $player) {
        expect($player->uuid)->toBeString()->not->toBeEmpty()
            ->and($player->nickname)->toBeString()->not->toBeEmpty()
            ->and($player->stats)->toBeArray()->not->toBeEmpty();
    }
});
