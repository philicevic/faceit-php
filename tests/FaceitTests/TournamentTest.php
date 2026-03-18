<?php

use Philicevic\FaceitPhp\DTO\Match\Detail\Info as MatchInfo;
use Philicevic\FaceitPhp\DTO\Match\Detail\Player as MatchPlayer;
use Philicevic\FaceitPhp\DTO\Match\Detail\Team as MatchTeam;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Player\Tournament as TournamentSimple;
use Philicevic\FaceitPhp\DTO\Tournament\Brackets;
use Philicevic\FaceitPhp\DTO\Tournament\BracketsMatch;
use Philicevic\FaceitPhp\DTO\Tournament\BracketsRound;
use Philicevic\FaceitPhp\DTO\Tournament\Team as TournamentTeam;
use Philicevic\FaceitPhp\DTO\Tournament\Teams;
use Philicevic\FaceitPhp\DTO\Tournament\Tournament;
use Philicevic\FaceitPhp\Requests\GetTournamentBracketsRequest;
use Philicevic\FaceitPhp\Requests\GetTournamentMatchesRequest;
use Philicevic\FaceitPhp\Requests\GetTournamentRequest;
use Philicevic\FaceitPhp\Requests\GetTournamentsRequest;
use Philicevic\FaceitPhp\Requests\GetTournamentTeamsRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->faceit = faceitMock();
});

// --- List tournaments ---

test('can list tournaments', function () {
    MockClient::global([
        GetTournamentsRequest::class => MockResponse::fixture('tournament_list'),
    ]);

    $response = $this->faceit->tournament()->list();

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(TournamentSimple::class);
});

test('tournament list hydrates all attributes', function () {
    MockClient::global([
        GetTournamentsRequest::class => MockResponse::fixture('tournament_list'),
    ]);

    $response = $this->faceit->tournament()->list(game: 'cs2', region: 'EU');
    $tournament = $response->items[0];

    expect($response->start)->toBe(0)
        ->and($response->end)->toBe(2)
        ->and($tournament->uuid)->toBe('tournament-1')
        ->and($tournament->name)->toBe('Weekly Cup #1')
        ->and($tournament->gameId)->toBe('cs2')
        ->and($tournament->region)->toBe('EU')
        ->and($tournament->status)->toBe('finished')
        ->and($tournament->faceitUrl)->toBeString()
        ->and($tournament->featuredImage)->toBeString()
        ->and($tournament->membershipType)->toBeString()
        ->and($tournament->matchType)->toBe('5v5')
        ->and($tournament->prizeType)->toBe('cash')
        ->and($tournament->teamSize)->toBe(5)
        ->and($tournament->maxSkill)->toBe(10)
        ->and($tournament->minSkill)->toBe(1)
        ->and($tournament->subscriptionsCount)->toBe(32)
        ->and($tournament->numberOfPlayers)->toBe(160)
        ->and($tournament->numberOfPlayersJoined)->toBe(160)
        ->and($tournament->numberOfPlayersCheckedin)->toBe(140)
        ->and($tournament->numberOfPlayersParticipants)->toBe(160)
        ->and($tournament->startedAt)->toBeInstanceOf(DateTime::class)
        ->and($tournament->startedAt->getTimestamp())->toBe(1710000000)
        ->and($tournament->whitelistCountries)->toBe(['DE', 'GB']);
});

// --- Get single tournament ---

test('can get tournament details', function () {
    MockClient::global([
        GetTournamentRequest::class => MockResponse::fixture('tournament_details'),
    ]);

    $tournament = $this->faceit->tournament()->get('tournament-1');

    expect($tournament)->toBeInstanceOf(Tournament::class);
});

test('tournament details hydrate all attributes', function () {
    MockClient::global([
        GetTournamentRequest::class => MockResponse::fixture('tournament_details'),
    ]);

    $tournament = $this->faceit->tournament()->get('tournament-1');

    expect($tournament->uuid)->toBe('tournament-1')
        ->and($tournament->name)->toBe('Weekly Cup #1')
        ->and($tournament->gameId)->toBe('cs2')
        ->and($tournament->region)->toBe('EU')
        ->and($tournament->status)->toBe('finished')
        ->and($tournament->faceitUrl)->toBeString()
        ->and($tournament->featuredImage)->toBeString()
        ->and($tournament->coverImage)->toBeString()
        ->and($tournament->description)->toBeString()
        ->and($tournament->membershipType)->toBeString()
        ->and($tournament->matchType)->toBe('5v5')
        ->and($tournament->prizeType)->toBe('cash')
        ->and($tournament->inviteType)->toBe('open')
        ->and($tournament->organizerId)->toBe('organizer-abc123')
        ->and($tournament->teamSize)->toBe(5)
        ->and($tournament->maxSkill)->toBe(10)
        ->and($tournament->minSkill)->toBe(1)
        ->and($tournament->numberOfPlayers)->toBe(160)
        ->and($tournament->anticheatRequired)->toBeTrue()
        ->and($tournament->calculateElo)->toBeFalse()
        ->and($tournament->custom)->toBeFalse()
        ->and($tournament->startedAt)->toBeInstanceOf(DateTime::class)
        ->and($tournament->whitelistCountries)->toBe(['DE', 'GB', 'FR']);
});

// --- Get tournament brackets ---

test('can get tournament brackets', function () {
    MockClient::global([
        GetTournamentBracketsRequest::class => MockResponse::fixture('tournament_brackets'),
    ]);

    $brackets = $this->faceit->tournament()->getBrackets('tournament-1');

    expect($brackets)->toBeInstanceOf(Brackets::class)
        ->and($brackets->matches)->toContainOnlyInstancesOf(BracketsMatch::class)
        ->and($brackets->rounds)->toContainOnlyInstancesOf(BracketsRound::class);
});

test('tournament brackets hydrate all attributes', function () {
    MockClient::global([
        GetTournamentBracketsRequest::class => MockResponse::fixture('tournament_brackets'),
    ]);

    $brackets = $this->faceit->tournament()->getBrackets('tournament-1');
    $match = $brackets->matches[0];
    $round = $brackets->rounds[0];

    expect($brackets->game)->toBe('cs2')
        ->and($brackets->name)->toBe('Weekly Cup #1')
        ->and($brackets->status)->toBe('finished')
        ->and($match->uuid)->toBe('1-aa11bb22-cc33-dd44-ee55-ff6677889900')
        ->and($match->faceitUrl)->toBeString()
        ->and($match->round)->toBe(1)
        ->and($match->position)->toBe(1)
        ->and($match->state)->toBe('FINISHED')
        ->and($match->results)->not->toBeNull()
        ->and($match->results->winner)->toBe('faction1')
        ->and($match->results->score->byFaction)->toHaveKey('faction1')
        ->and($round->round)->toBe(1)
        ->and($round->label)->toBe('Round of 16')
        ->and($round->matchesCount)->toBe(8)
        ->and($round->bestOf)->toBe(1)
        ->and($round->startTime)->toBeInt()
        ->and($round->startsAsap)->toBeFalse()
        ->and($round->substitutionTime)->toBe(300)
        ->and($round->substitutionsAllowed)->toBeTrue();
});

// --- Get tournament matches ---

test('can get tournament matches', function () {
    MockClient::global([
        GetTournamentMatchesRequest::class => MockResponse::fixture('tournament_matches'),
    ]);

    $response = $this->faceit->tournament()->getMatches('tournament-1');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(MatchInfo::class);
});

test('tournament matches hydrate all attributes', function () {
    MockClient::global([
        GetTournamentMatchesRequest::class => MockResponse::fixture('tournament_matches'),
    ]);

    $response = $this->faceit->tournament()->getMatches('tournament-1');
    $match = $response->items[0];
    $team = $match->teams[0];
    $player = $team->players[0];

    expect($response->start)->toBe(0)
        ->and($response->end)->toBe(1)
        ->and($match->uuid)->toBe('1-aa11bb22-cc33-dd44-ee55-ff6677889900')
        ->and($match->game)->toBe('cs2')
        ->and($match->region)->toBe('EU')
        ->and($match->competitionId)->toBe('tournament-1')
        ->and($match->competitionType)->toBe('tournament')
        ->and($match->competitionName)->toBeString()
        ->and($match->status)->toBe('FINISHED')
        ->and($match->bestOf)->toBe(1)
        ->and($match->startedAt)->toBeInstanceOf(DateTime::class)
        ->and($match->finishedAt)->toBeInstanceOf(DateTime::class)
        ->and($match->faceitUrl)->toBeString()
        ->and($match->results->winner)->toBe('faction1')
        ->and($match->teams)->toContainOnlyInstancesOf(MatchTeam::class)
        ->and($team->players)->toContainOnlyInstancesOf(MatchPlayer::class)
        ->and($player->uuid)->toBeString()
        ->and($player->nickname)->toBeString()
        ->and($player->gamePlayerId)->toBeString();
});

// --- Get tournament teams ---

test('can get tournament teams', function () {
    MockClient::global([
        GetTournamentTeamsRequest::class => MockResponse::fixture('tournament_teams'),
    ]);

    $teams = $this->faceit->tournament()->getTeams('tournament-1');

    expect($teams)->toBeInstanceOf(Teams::class)
        ->and($teams->checkedIn)->toContainOnlyInstancesOf(TournamentTeam::class)
        ->and($teams->finished)->toContainOnlyInstancesOf(TournamentTeam::class)
        ->and($teams->joined)->toContainOnlyInstancesOf(TournamentTeam::class)
        ->and($teams->started)->toContainOnlyInstancesOf(TournamentTeam::class);
});

test('tournament teams hydrate all attributes', function () {
    MockClient::global([
        GetTournamentTeamsRequest::class => MockResponse::fixture('tournament_teams'),
    ]);

    $teams = $this->faceit->tournament()->getTeams('tournament-1');
    $team = $teams->checkedIn[0];

    expect($team->uuid)->toBe('team-uuid-1')
        ->and($team->nickname)->toBe('TeamAlpha')
        ->and($team->teamLeader)->toBe('player-uuid-1')
        ->and($team->teamType)->toBe('premade')
        ->and($team->skillLevel)->toBe(8)
        ->and($team->subsDone)->toBe(0);
});

test('tournament teams groups each have one team', function () {
    MockClient::global([
        GetTournamentTeamsRequest::class => MockResponse::fixture('tournament_teams'),
    ]);

    $teams = $this->faceit->tournament()->getTeams('tournament-1');

    expect($teams->checkedIn)->toHaveCount(1)
        ->and($teams->finished)->toHaveCount(1)
        ->and($teams->joined)->toHaveCount(1)
        ->and($teams->started)->toHaveCount(1);
});
