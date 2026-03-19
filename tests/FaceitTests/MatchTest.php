<?php

use Philicevic\FaceitPhp\DTO\Match\Detail\Info as MatchDetail;
use Philicevic\FaceitPhp\DTO\Match\Detail\Player as MatchDetailPlayer;
use Philicevic\FaceitPhp\DTO\Match\Detail\Team as MatchDetailTeam;
use Philicevic\FaceitPhp\DTO\Match\Stats\MatchStats;
use Philicevic\FaceitPhp\DTO\Match\Stats\Round as MatchRound;
use Philicevic\FaceitPhp\DTO\Match\Stats\Team as MatchStatsTeam;
use Philicevic\FaceitPhp\DTO\Player\StatsPlayer as MatchStatsPlayer;
use Philicevic\FaceitPhp\Requests\GetMatchDetailsRequest;
use Philicevic\FaceitPhp\Requests\GetMatchStatsRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->faceit = faceitMock();
});

test('can get match details', function () {
    MockClient::global([
        GetMatchDetailsRequest::class => MockResponse::fixture('match_details'),
    ]);

    $match = $this->faceit->match()->get('1-bb13fd78-e183-4d37-8a4b-ceed67da5265');

    expect($match)->toBeInstanceOf(MatchDetail::class)
        ->and($match->teams)->toContainOnlyInstancesOf(MatchDetailTeam::class)
        ->and($match->teams[0]->players)->toContainOnlyInstancesOf(MatchDetailPlayer::class)
        ->and($match->teams[0]->players[0]->gamePlayerId)->toBeString();
});

test('match details hydrate all attributes', function () {
    MockClient::global([
        GetMatchDetailsRequest::class => MockResponse::fixture('match_details'),
    ]);

    $match = $this->faceit->match()->get('1-bb13fd78-e183-4d37-8a4b-ceed67da5265');
    $team = $match->teams[0];
    $player = $team->players[0];

    expect($match->uuid)->toBeString()
        ->and($match->competitionId)->toBeString()
        ->and($match->competitionName)->toBeString()
        ->and($match->competitionType)->toBeString()
        ->and($match->bestOf)->toBe(1)
        ->and($match->status)->toBeString()
        ->and($match->game)->toBeString()
        ->and($match->region)->toBeString()
        ->and($match->organizerId)->toBeString()
        ->and($match->startedAt)->toBeInstanceOf(DateTime::class)
        ->and($match->startedAt->getTimestamp())->toBeGreaterThan(0)
        ->and($match->finishedAt)->toBeInstanceOf(DateTime::class)
        ->and($match->finishedAt->getTimestamp())->toBeGreaterThan(0)
        ->and($match->scheduledAt)->toBeInstanceOf(DateTime::class)
        ->and($match->scheduledAt->getTimestamp())->toBeGreaterThan(0)
        ->and($match->faceitUrl)->toBeString()
        ->and($match->results->winner)->toBeString()
        ->and($match->results->score->byFaction)->toBeArray()
        ->and($team->uuid)->toBeString()
        ->and($team->name)->toBeString()
        ->and($team->avatar)->toBeString()
        ->and($team->leader)->toBeString()
        ->and($team->type)->toBeString()
        ->and($player->uuid)->toBeString()
        ->and($player->nickname)->toBeString()
        ->and($player->avatar)->toBeString()
        ->and($player->membership)->toBeString()
        ->and($player->gamePlayerId)->toBeString()
        ->and($player->gamePlayerName)->toBeString()
        ->and($player->gameSkillLevel)->toBeInt()
        ->and($player->anticheatRequired)->toBeBool();
});

test('can get match stats', function () {
    MockClient::global([
        GetMatchStatsRequest::class => MockResponse::fixture('match_stats'),
    ]);
    $matchStats = $this->faceit->match()->getStats('1-bb13fd78-e183-4d37-8a4b-ceed67da5265');
    expect($matchStats)->toBeInstanceOf(MatchStats::class);
});

test('match stats contain rounds', function () {
    MockClient::global([
        GetMatchStatsRequest::class => MockResponse::fixture('match_stats'),
    ]);
    $matchStats = $this->faceit->match()->getStats('1-bb13fd78-e183-4d37-8a4b-ceed67da5265');
    expect($matchStats->rounds)->toContainOnlyInstancesOf(MatchRound::class);
});

test('round stats get populated', function () {
    MockClient::global([
        GetMatchStatsRequest::class => MockResponse::fixture('match_stats'),
    ]);
    $matchStats = $this->faceit->match()->getStats('1-bb13fd78-e183-4d37-8a4b-ceed67da5265');
    $roundStats = $matchStats->rounds[0]->stats;
    expect($roundStats)->toBeArray()
        ->and(count($roundStats))->toBeGreaterThan(0);
});

test('match stats hydrate all attributes', function () {
    MockClient::global([
        GetMatchStatsRequest::class => MockResponse::fixture('match_stats'),
    ]);

    $matchStats = $this->faceit->match()->getStats('1-bb13fd78-e183-4d37-8a4b-ceed67da5265');
    $round = $matchStats->rounds[0];
    $team = $round->teams[0];
    $player = $team->players[0];

    expect($round->bestOf)->toBeInt()
        ->and($round->competitionId)->toBeString()
        ->and($round->gameId)->toBe('cs2')
        ->and($round->gameMode)->toBe('5v5')
        ->and($round->matchId)->toBe('1-bb13fd78-e183-4d37-8a4b-ceed67da5265')
        ->and($round->matchRound)->toBeInt()
        ->and($round->played)->toBeBool()
        ->and($round->stats)->toHaveKey('Map')
        ->and($team->uuid)->toBeString()
        ->and($team->premade)->toBeBool()
        ->and($team->stats)->toHaveKey('Final Score')
        ->and($player->uuid)->toBeString()
        ->and($player->nickname)->toBeString()
        ->and($player->stats)->toHaveKey('Kills');
});

test('teams contain 5 players', function () {
    MockClient::global([
        GetMatchStatsRequest::class => MockResponse::fixture('match_stats'),
    ]);
    $matchStats = $this->faceit->match()->getStats('1-bb13fd78-e183-4d37-8a4b-ceed67da5265');
    $round = $matchStats->rounds[0];
    expect($round->teams)->toContainOnlyInstancesOf(MatchStatsTeam::class)
        ->and($round->teams[0]->players)->toHaveCount(5)
        ->and($round->teams[1]->players)->toHaveCount(5);
});

test('players contain player stats as array', function () {
    MockClient::global([
        GetMatchStatsRequest::class => MockResponse::fixture('match_stats'),
    ]);
    $matchStats = $this->faceit->match()->getStats('1-bb13fd78-e183-4d37-8a4b-ceed67da5265');

    $round = $matchStats->rounds[0];
    $player = $round->teams[0]->players[0];
    expect($player)->toBeInstanceOf(MatchStatsPlayer::class)
        ->and($player->stats)->toBeArray()
        ->and(count($player->stats))->toBeGreaterThan(0);
});
