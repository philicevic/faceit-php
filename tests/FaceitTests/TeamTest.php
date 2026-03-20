<?php

use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Player\Tournament;
use Philicevic\FaceitPhp\DTO\Team\Team;
use Philicevic\FaceitPhp\DTO\Team\TeamStats;
use Philicevic\FaceitPhp\DTO\UserSimple;
use Philicevic\FaceitPhp\Requests\GetTeamRequest;
use Philicevic\FaceitPhp\Requests\GetTeamStatsRequest;
use Philicevic\FaceitPhp\Requests\GetTeamTournamentsRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->faceit = faceitMock();
});

// Test get team
test('can get team', function () {
    MockClient::global([
        GetTeamRequest::class => MockResponse::fixture('team_details'),
    ]);
    $team = $this->faceit->team()->get('team-uuid');
    expect($team)->toBeInstanceOf(Team::class);
});

test('team details hydrate all attributes', function () {
    MockClient::global([
        GetTeamRequest::class => MockResponse::fixture('team_details'),
    ]);
    $team = $this->faceit->team()->get('team-uuid');
    $member = $team->members[0];

    expect($team->uuid)->toBeString()
        ->and($team->name)->toBeString()
        ->and($team->nickname)->toBeString()
        ->and($team->avatar)->toBeString()
        ->and($team->coverImage)->toBeString()
        ->and($team->description)->toBeString()
        ->and($team->faceitUrl)->toBeString()
        ->and($team->game)->toBeString()
        ->and($team->leader)->toBeString()
        ->and($team->teamType)->toBeString()
        ->and($team->chatRoomId)->toBeString()
        ->and($team->members)->toContainOnlyInstancesOf(UserSimple::class)
        ->and($member->uuid)->toBeString()
        ->and($member->nickname)->toBeString()
        ->and($member->skillLevel)->toBeInt();
});

// Test get team stats
test('can get team stats', function () {
    MockClient::global([
        GetTeamStatsRequest::class => MockResponse::fixture('team_stats'),
    ]);
    $stats = $this->faceit->team()->getStats('team-uuid', 'cs2');
    expect($stats)->toBeInstanceOf(TeamStats::class);
});

test('team stats hydrate all attributes', function () {
    MockClient::global([
        GetTeamStatsRequest::class => MockResponse::fixture('team_stats'),
    ]);
    $stats = $this->faceit->team()->getStats('team-uuid', 'cs2');
    expect($stats->teamId)->toBeString()
        ->and($stats->gameId)->toBe('cs2')
        ->and($stats->lifetime)->toBeArray()
        ->and($stats->lifetime)->toHaveKey('Win Rate %')
        ->and($stats->segments)->toBeArray()
        ->and($stats->segments[0])->toHaveKey('label');
});

// Test get team tournaments
test('can get team tournaments', function () {
    MockClient::global([
        GetTeamTournamentsRequest::class => MockResponse::fixture('team_tournaments'),
    ]);
    $response = $this->faceit->team()->getTournaments('team-uuid');
    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Tournament::class);
});

test('team tournaments hydrate all attributes', function () {
    MockClient::global([
        GetTeamTournamentsRequest::class => MockResponse::fixture('team_tournaments'),
    ]);
    $tournament = $this->faceit->team()->getTournaments('team-uuid')->items[0];
    expect($tournament->uuid)->toBeString()
        ->and($tournament->name)->toBeString()
        ->and($tournament->gameId)->toBeString()
        ->and($tournament->teamSize)->toBeInt()
        ->and($tournament->startedAt)->toBeInstanceOf(DateTime::class);
});
