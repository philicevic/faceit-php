<?php

use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Player\Tournament;
use Philicevic\FaceitPhp\DTO\Team\Member;
use Philicevic\FaceitPhp\DTO\Team\Stats;
use Philicevic\FaceitPhp\DTO\Team\Team;
use Philicevic\FaceitPhp\Requests\GetTeamRequest;
use Philicevic\FaceitPhp\Requests\GetTeamStatsRequest;
use Philicevic\FaceitPhp\Requests\GetTeamTournamentsRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->faceit = faceitMock();
});

test('can get team', function () {
    MockClient::global([
        GetTeamRequest::class => MockResponse::fixture('team_details'),
    ]);

    $team = $this->faceit->team()->get('team-uuid-1');

    expect($team)->toBeInstanceOf(Team::class)
        ->and($team->members)->toContainOnlyInstancesOf(Member::class);
});

test('team hydrates all attributes', function () {
    MockClient::global([
        GetTeamRequest::class => MockResponse::fixture('team_details'),
    ]);

    $team = $this->faceit->team()->get('team-uuid-1');

    expect($team->uuid)->toBe('team-uuid-1')
        ->and($team->name)->toBe('ProTeam')
        ->and($team->game)->toBe('cs2')
        ->and($team->leader)->toBe('player-uuid-1')
        ->and($team->faceitUrl)->toBeString()
        ->and($team->members[0]->uuid)->toBe('player-uuid-1')
        ->and($team->members[0]->nickname)->toBe('ProPlayer1');
});

test('can get team stats', function () {
    MockClient::global([
        GetTeamStatsRequest::class => MockResponse::fixture('team_stats'),
    ]);

    $stats = $this->faceit->team()->getStats('team-uuid-1', 'cs2');

    expect($stats)->toBeInstanceOf(Stats::class);
});

test('team stats hydrate all attributes', function () {
    MockClient::global([
        GetTeamStatsRequest::class => MockResponse::fixture('team_stats'),
    ]);

    $stats = $this->faceit->team()->getStats('team-uuid-1', 'cs2');

    expect($stats->teamId)->toBe('team-uuid-1')
        ->and($stats->gameId)->toBe('cs2')
        ->and($stats->lifetime)->toBeArray()
        ->and($stats->segments)->toBeArray();
});

test('can get team tournaments', function () {
    MockClient::global([
        GetTeamTournamentsRequest::class => MockResponse::fixture('team_tournaments'),
    ]);

    $response = $this->faceit->team()->getTournaments('team-uuid-1');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Tournament::class);
});
