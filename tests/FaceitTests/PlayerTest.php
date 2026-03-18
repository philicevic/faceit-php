<?php

use Philicevic\FaceitPhp\DTO\Ban;
use Philicevic\FaceitPhp\DTO\Match\Summary\Info as MatchSummary;
use Philicevic\FaceitPhp\DTO\Match\Summary\Player as MatchSummaryPlayer;
use Philicevic\FaceitPhp\DTO\Match\Summary\Team as MatchSummaryTeam;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Player;
use Philicevic\FaceitPhp\DTO\Player\GameMatchStats;
use Philicevic\FaceitPhp\DTO\Player\Hub;
use Philicevic\FaceitPhp\DTO\Player\LifetimeStats;
use Philicevic\FaceitPhp\DTO\Player\Team\Member as TeamMember;
use Philicevic\FaceitPhp\DTO\Player\Team\Team as PlayerTeam;
use Philicevic\FaceitPhp\DTO\Player\Tournament;
use Philicevic\FaceitPhp\Faceit;
use Philicevic\FaceitPhp\Requests\GetPlayerBansRequest;
use Philicevic\FaceitPhp\Requests\GetPlayerGameStatsRequest;
use Philicevic\FaceitPhp\Requests\GetPlayerHubsRequest;
use Philicevic\FaceitPhp\Requests\GetPlayerLifetimeStatsRequest;
use Philicevic\FaceitPhp\Requests\GetPlayerLookupRequest;
use Philicevic\FaceitPhp\Requests\GetPlayerMatchesRequest;
use Philicevic\FaceitPhp\Requests\GetPlayerRequest;
use Philicevic\FaceitPhp\Requests\GetPlayerTeamsRequest;
use Philicevic\FaceitPhp\Requests\GetPlayerTournamentsRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    /** @var Faceit $faceit */
    $this->faceit = faceitMock();
});

test('can get player dto', function () {
    MockClient::global([
        GetPlayerRequest::class => MockResponse::fixture('player_details'),
    ]);

    $player = $this->faceit->player()->get('a58f6134-4f31-4611-8431-b0a9630bea77');

    expect($player)->toBeInstanceOf(Player::class);
});

test('player details get populated', function () {
    MockClient::global([
        GetPlayerRequest::class => MockResponse::fixture('player_details'),
    ]);

    $player = $this->faceit->player()->get('a58f6134-4f31-4611-8431-b0a9630bea77');

    expect($player->uuid)->toBeString()
        ->and($player->nickname)->toBeString()
        ->and($player->avatar)->toBeString()
        ->and($player->country)->toBeString()
        ->and($player->coverImage)->toBeString()
        ->and($player->activatedAt)->toBeInstanceOf(DateTime::class)
        ->and($player->membershipType)->toBeString()
        ->and($player->games)->toBeArray()
        ->and($player->memberships)->toBeArray();
});

test('player details hydrate all attributes', function () {
    MockClient::global([
        GetPlayerRequest::class => MockResponse::fixture('player_details'),
    ]);

    $player = $this->faceit->player()->get('a58f6134-4f31-4611-8431-b0a9630bea77');
    $gameProfile = $player->games['cs2'];

    expect($player->uuid)->toBeString()
        ->and($player->nickname)->toBeString()
        ->and($player->avatar)->toBeString()
        ->and($player->country)->toBeString()
        ->and($player->coverImage)->toBeString()
        ->and($player->activatedAt)->toBeInstanceOf(DateTime::class)
        ->and($player->activatedAt->getTimestamp())->toBeGreaterThan(0)
        ->and($player->faceitUrl)->toBeString()
        ->and($player->friendsIds)->toBeArray()
        ->and($player->games)->toHaveKey('cs2')
        ->and($player->memberships)->toBeArray()
        ->and($player->platforms)->toHaveKey('steam')
        ->and($player->membershipType)->toBeString()
        ->and($player->steamId64)->toBeString()
        ->and($player->steamNickname)->toBeString()
        ->and($player->verified)->toBeBool()
        ->and($gameProfile->gameId)->toBeString()
        ->and($gameProfile->gamePlayerId)->toBeString()
        ->and($gameProfile->gamePlayerName)->toBeString()
        ->and($gameProfile->gameProfileId)->toBeString()
        ->and($gameProfile->region)->toBeString()
        ->and($gameProfile->skillLevel)->toBeInt()
        ->and($gameProfile->skillLevelLabel)->toBeString()
        ->and($gameProfile->faceitElo)->toBeInt()
        ->and($gameProfile->regions)->toBeArray();
});

test('player activation date is not empty', function () {
    MockClient::global([
        GetPlayerRequest::class => MockResponse::fixture('player_details'),
    ]);

    $player = $this->faceit->player()->get('a58f6134-4f31-4611-8431-b0a9630bea77');

    expect($player->activatedAt->getTimestamp())->not->toBe(0);
});

test('can lookup player by nickname', function () {
    MockClient::global([
        GetPlayerLookupRequest::class => MockResponse::fixture('player_lookup'),
    ]);

    $player = $this->faceit->player()->lookup(nickname: 'xqsp4m');

    expect($player)->toBeInstanceOf(Player::class)
        ->and($player->nickname)->toBe('xqsp4m');
});

test('player lookup hydrates all attributes', function () {
    MockClient::global([
        GetPlayerLookupRequest::class => MockResponse::fixture('player_lookup'),
    ]);

    $player = $this->faceit->player()->lookup(nickname: 'xqsp4m');

    expect($player->uuid)->toBeString()
        ->and($player->nickname)->toBeString()
        ->and($player->avatar)->toBeString()
        ->and($player->country)->toBeString()
        ->and($player->coverImage)->toBeString()
        ->and($player->activatedAt)->toBeInstanceOf(DateTime::class)
        ->and($player->activatedAt->getTimestamp())->toBeGreaterThan(0)
        ->and($player->faceitUrl)->toBeString()
        ->and($player->memberships)->toBeArray()
        ->and($player->platforms['steam'])->toBeString()
        ->and($player->verified)->toBeBool();
});

test('can get player bans', function () {
    MockClient::global([
        GetPlayerBansRequest::class => MockResponse::fixture('player_bans'),
    ]);

    $response = $this->faceit->player()->getBans('59ba3a1a-7036-47d9-bcf4-009194dbcbeb');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Ban::class)
        ->and($response->items[0]->startsAt)->toBeInstanceOf(DateTime::class)
        ->and($response->start)->toBe(0)
        ->and($response->end)->toBeGreaterThan(0);
});

test('player bans hydrate all attributes', function () {
    MockClient::global([
        GetPlayerBansRequest::class => MockResponse::fixture('player_bans'),
    ]);

    $ban = $this->faceit->player()->getBans('59ba3a1a-7036-47d9-bcf4-009194dbcbeb')->items[0];

    expect($ban->userId)->toBeString()
        ->and($ban->nickname)->toBeString()
        ->and($ban->reason)->toBeString()
        ->and($ban->type)->toBeString()
        ->and($ban->game)->toBeString()
        ->and($ban->startsAt)->toBeInstanceOf(DateTime::class)
        ->and($ban->startsAt->getTimestamp())->toBeGreaterThan(0)
        ->and($ban->endsAt)->toBeInstanceOf(DateTime::class)
        ->and($ban->endsAt->getTimestamp())->toBeGreaterThan(0);
});

test('can get player game stats', function () {
    MockClient::global([
        GetPlayerGameStatsRequest::class => MockResponse::fixture('player_game_stats'),
    ]);

    $response = $this->faceit->player()->getGameStats('a58f6134-4f31-4611-8431-b0a9630bea77', 'cs2');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(GameMatchStats::class)
        ->and($response->items[0]->stats)->toHaveKey('Kills');
});

test('player game stats hydrate all attributes', function () {
    MockClient::global([
        GetPlayerGameStatsRequest::class => MockResponse::fixture('player_game_stats'),
    ]);

    $stats = $this->faceit->player()->getGameStats('a58f6134-4f31-4611-8431-b0a9630bea77', 'cs2')->items[0];

    expect($stats->stats)->toBeArray()
        ->and($stats->stats)->toHaveKey('Kills')
        ->and($stats->stats)->toHaveKey('K/D Ratio')
        ->and($stats->stats['Kills'])->toBeString()
        ->and($stats->stats['K/D Ratio'])->toBeString();
});

test('can get player matches', function () {
    MockClient::global([
        GetPlayerMatchesRequest::class => MockResponse::fixture('player_matches'),
    ]);

    $response = $this->faceit->player()->getMatches('a58f6134-4f31-4611-8431-b0a9630bea77', 'cs2');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(MatchSummary::class)
        ->and($response->items[0]->teams)->toContainOnlyInstancesOf(MatchSummaryTeam::class)
        ->and($response->items[0]->teams[0]->players)->toContainOnlyInstancesOf(MatchSummaryPlayer::class)
        ->and($response->items[0]->teams[0]->players[0]->gamePlayerId)->toBeString()
        ->and($response->from)->toBe(1710000000)
        ->and($response->to)->toBe(1710100000);
});

test('player matches hydrate all attributes', function () {
    MockClient::global([
        GetPlayerMatchesRequest::class => MockResponse::fixture('player_matches'),
    ]);

    $match = $this->faceit->player()->getMatches('a58f6134-4f31-4611-8431-b0a9630bea77', 'cs2')->items[0];
    $team = $match->teams[0];
    $player = $team->players[0];

    expect($match->uuid)->toBeString()
        ->and($match->competitionId)->toBeString()
        ->and($match->competitionName)->toBeString()
        ->and($match->competitionType)->toBeString()
        ->and($match->status)->toBeString()
        ->and($match->gameId)->toBeString()
        ->and($match->gameMode)->toBeString()
        ->and($match->matchType)->toBeString()
        ->and($match->maxPlayers)->toBeInt()
        ->and($match->organizerId)->toBeString()
        ->and($match->region)->toBeString()
        ->and($match->faceitUrl)->toBeString()
        ->and($match->startedAt)->toBeInstanceOf(DateTime::class)
        ->and($match->startedAt->getTimestamp())->toBeGreaterThan(0)
        ->and($match->finishedAt)->toBeInstanceOf(DateTime::class)
        ->and($match->finishedAt->getTimestamp())->toBeGreaterThan(0)
        ->and($match->results->winner)->toBeString()
        ->and($match->results->score->byFaction)->toBeArray()
        ->and($match->playingPlayers)->toBeArray()
        ->and($team->uuid)->toBeString()
        ->and($team->nickname)->toBeString()
        ->and($team->avatar)->toBeString()
        ->and($player->uuid)->toBeString()
        ->and($player->nickname)->toBeString()
        ->and($player->avatar)->toBeString()
        ->and($player->faceitUrl)->toBeString()
        ->and($player->gamePlayerId)->toBeString()
        ->and($player->gamePlayerName)->toBeString();
});

test('can get player hubs', function () {
    MockClient::global([
        GetPlayerHubsRequest::class => MockResponse::fixture('player_hubs'),
    ]);

    $response = $this->faceit->player()->getHubs('a58f6134-4f31-4611-8431-b0a9630bea77');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Hub::class)
        ->and($response->items[0]->uuid)->toBe('hub-1');
});

test('player hubs hydrate all attributes', function () {
    MockClient::global([
        GetPlayerHubsRequest::class => MockResponse::fixture('player_hubs'),
    ]);

    $hub = $this->faceit->player()->getHubs('a58f6134-4f31-4611-8431-b0a9630bea77')->items[0];

    expect($hub->uuid)->toBeString()
        ->and($hub->name)->toBeString()
        ->and($hub->avatar)->toBeString()
        ->and($hub->coverImage)->toBeString()
        ->and($hub->backgroundImage)->toBeString()
        ->and($hub->faceitUrl)->toBeString()
        ->and($hub->description)->toBeString()
        ->and($hub->gameId)->toBeString()
        ->and($hub->region)->toBeString();
});

test('can get player lifetime stats', function () {
    MockClient::global([
        GetPlayerLifetimeStatsRequest::class => MockResponse::fixture('player_lifetime_stats'),
    ]);

    $stats = $this->faceit->player()->getStats('a58f6134-4f31-4611-8431-b0a9630bea77', 'cs2');

    expect($stats)->toBeInstanceOf(LifetimeStats::class)
        ->and($stats->playerId)->toBe('a58f6134-4f31-4611-8431-b0a9630bea77')
        ->and($stats->lifetime)->toHaveKey('Average K/D Ratio');
});

test('player lifetime stats hydrate all attributes', function () {
    MockClient::global([
        GetPlayerLifetimeStatsRequest::class => MockResponse::fixture('player_lifetime_stats'),
    ]);

    $stats = $this->faceit->player()->getStats('a58f6134-4f31-4611-8431-b0a9630bea77', 'cs2');

    expect($stats->playerId)->toBeString()
        ->and($stats->gameId)->toBeString()
        ->and($stats->lifetime)->toBeArray()
        ->and($stats->lifetime)->toHaveKey('Average K/D Ratio')
        ->and($stats->lifetime)->toHaveKey('Matches')
        ->and($stats->segments)->toBeArray()
        ->and($stats->segments[0])->toHaveKey('label')
        ->and($stats->segments[0])->toHaveKey('stats');
});

test('can get player teams', function () {
    MockClient::global([
        GetPlayerTeamsRequest::class => MockResponse::fixture('player_teams'),
    ]);

    $response = $this->faceit->player()->getTeams('a58f6134-4f31-4611-8431-b0a9630bea77');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(PlayerTeam::class)
        ->and($response->items[0]->members)->toContainOnlyInstancesOf(TeamMember::class);
});

test('player teams hydrate all attributes', function () {
    MockClient::global([
        GetPlayerTeamsRequest::class => MockResponse::fixture('player_teams'),
    ]);

    $team = $this->faceit->player()->getTeams('a58f6134-4f31-4611-8431-b0a9630bea77')->items[0];
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
        ->and($member->uuid)->toBeString()
        ->and($member->nickname)->toBeString()
        ->and($member->avatar)->toBeString()
        ->and($member->country)->toBeString()
        ->and($member->faceitUrl)->toBeString()
        ->and($member->membershipType)->toBeString()
        ->and($member->memberships)->toBeArray()
        ->and($member->skillLevel)->toBeInt();
});

test('can get player tournaments', function () {
    MockClient::global([
        GetPlayerTournamentsRequest::class => MockResponse::fixture('player_tournaments'),
    ]);

    $response = $this->faceit->player()->getTournaments('a58f6134-4f31-4611-8431-b0a9630bea77');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Tournament::class)
        ->and($response->items[0]->uuid)->toBe('tournament-1');
});

test('player tournaments hydrate all attributes', function () {
    MockClient::global([
        GetPlayerTournamentsRequest::class => MockResponse::fixture('player_tournaments'),
    ]);

    $tournament = $this->faceit->player()->getTournaments('a58f6134-4f31-4611-8431-b0a9630bea77')->items[0];

    expect($tournament->uuid)->toBeString()
        ->and($tournament->name)->toBeString()
        ->and($tournament->gameId)->toBeString()
        ->and($tournament->region)->toBeString()
        ->and($tournament->status)->toBeString()
        ->and($tournament->faceitUrl)->toBeString()
        ->and($tournament->featuredImage)->toBeString()
        ->and($tournament->membershipType)->toBeString()
        ->and($tournament->matchType)->toBeString()
        ->and($tournament->prizeType)->toBeString()
        ->and($tournament->teamSize)->toBeInt()
        ->and($tournament->maxSkill)->toBeInt()
        ->and($tournament->minSkill)->toBeInt()
        ->and($tournament->subscriptionsCount)->toBeInt()
        ->and($tournament->numberOfPlayers)->toBeInt()
        ->and($tournament->numberOfPlayersJoined)->toBeInt()
        ->and($tournament->numberOfPlayersCheckedin)->toBeInt()
        ->and($tournament->numberOfPlayersParticipants)->toBeInt()
        ->and($tournament->startedAt)->toBeInstanceOf(DateTime::class)
        ->and($tournament->startedAt->getTimestamp())->toBeGreaterThan(0)
        ->and($tournament->whitelistCountries)->toBeArray();
});
