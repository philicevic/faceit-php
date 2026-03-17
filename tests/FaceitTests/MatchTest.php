<?php

use Philicevic\FaceitPhp\DTO\Match\Round;
use Philicevic\FaceitPhp\DTO\Match\Stats\PlayerStats;
use Philicevic\FaceitPhp\DTO\Match\Stats\RoundStats;
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

    expect($match)->toBeInstanceOf(\Philicevic\FaceitPhp\DTO\Match\Info::class);
});

test('can get match stats', function () {
    MockClient::global([
        GetMatchStatsRequest::class => MockResponse::fixture('match_stats'),
    ]);
    $matchStats = $this->faceit->match()->getStats('1-bb13fd78-e183-4d37-8a4b-ceed67da5265');
    expect($matchStats)->toBeInstanceOf(\Philicevic\FaceitPhp\DTO\Match\Stats\MatchStats::class);
});

test('match stats contain rounds', function () {
    MockClient::global([
        GetMatchStatsRequest::class => MockResponse::fixture('match_stats'),
    ]);
    $matchStats = $this->faceit->match()->getStats('1-bb13fd78-e183-4d37-8a4b-ceed67da5265');
    expect($matchStats->rounds)->toContainOnlyInstancesOf(Round::class);
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

test('teams contain 5 players', function () {
    MockClient::global([
        GetMatchStatsRequest::class => MockResponse::fixture('match_stats'),
    ]);
    $matchStats = $this->faceit->match()->getStats('1-bb13fd78-e183-4d37-8a4b-ceed67da5265');
    $round = $matchStats->rounds[0];
    expect($round->teams[0]->players)->toHaveCount(5)
        ->and($round->teams[1]->players)->toHaveCount(5);
});

test('players contain player stats as array', function () {
    MockClient::global([
        GetMatchStatsRequest::class => MockResponse::fixture('match_stats'),
    ]);
    $matchStats = $this->faceit->match()->getStats('1-bb13fd78-e183-4d37-8a4b-ceed67da5265');
    
    $round = $matchStats->rounds[0];
    $player = $round->teams[0]->players[0];
    expect($player->stats)->toBeArray()
        ->and(count($player->stats))->toBeGreaterThan(0);
});