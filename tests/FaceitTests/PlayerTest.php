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
use Philicevic\FaceitPhp\DTO\Player\PlayerPlatform;
use Philicevic\FaceitPhp\DTO\Team\Team as PlayerTeam;
use Philicevic\FaceitPhp\DTO\Tournament;
use Philicevic\FaceitPhp\Enums\ChampionshipStatus;
use Philicevic\FaceitPhp\Enums\CompetitionType;
use Philicevic\FaceitPhp\Enums\MatchStatus;
use Philicevic\FaceitPhp\Enums\MembershipType;
use Philicevic\FaceitPhp\Enums\Region;
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
    $this->playerId = 'ffe3566c-9574-4f1b-8012-bf4d42aeb898';
});

test('can get player dto', function () {
    MockClient::global([
        GetPlayerRequest::class => MockResponse::fixture('player_details'),
    ]);

    $player = $this->faceit->player()->get($this->playerId);

    expect($player)->toBeInstanceOf(Player::class);
});

test('player details get populated', function () {
    MockClient::global([
        GetPlayerRequest::class => MockResponse::fixture('player_details'),
    ]);

    $player = $this->faceit->player()->get($this->playerId);

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

    $player = $this->faceit->player()->get($this->playerId);
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
        ->and($player->platforms)->each->toBeInstanceOf(PlayerPlatform::class)
        ->and($player->membershipType)->toBeString()
        ->and($player->steamId64)->toBeString()
        ->and($player->steamNickname)->toBeString()
        ->and($player->verified)->toBeBool()
        ->and($gameProfile->gameId)->toBeString()
        ->and($gameProfile->gamePlayerId)->toBeString()
        ->and($gameProfile->gamePlayerName)->toBeString()
        ->and($gameProfile->gameProfileId)->toBeString()
        ->and($gameProfile->region)->toBeIn(Region::cases())
        ->and($gameProfile->skillLevel)->toBeInt()
        ->and($gameProfile->skillLevelLabel)->toBeString()
        ->and($gameProfile->faceitElo)->toBeInt()
        ->and($gameProfile->regions)->toBeArray()->each->toBeIn(Region::cases());
});

test('player activation date is not empty', function () {
    MockClient::global([
        GetPlayerRequest::class => MockResponse::fixture('player_details'),
    ]);

    $player = $this->faceit->player()->get($this->playerId);

    expect($player->activatedAt->getTimestamp())->not->toBe(0);
});

test('can lookup player by nickname', function () {
    MockClient::global([
        GetPlayerLookupRequest::class => MockResponse::fixture('player_lookup'),
    ]);

    $player = $this->faceit->player()->lookup(nickname: 'Darwin');

    expect($player)->toBeInstanceOf(Player::class)
        ->and($player->nickname)->toBe('Darwin');
});

test('player lookup hydrates all attributes', function () {
    MockClient::global([
        GetPlayerLookupRequest::class => MockResponse::fixture('player_lookup'),
    ]);

    $player = $this->faceit->player()->lookup(nickname: 'Darwin');

    expect($player->uuid)->toBeUuid()
        ->and($player->nickname)->toBeString()
        ->and($player->avatar)->toBeString()
        ->and($player->country)->toBeString()
        ->and($player->coverImage)->toBeString()
        ->and($player->activatedAt)->toBeInstanceOf(DateTime::class)
        ->and($player->activatedAt->getTimestamp())->toBeGreaterThan(0)
        ->and($player->faceitUrl)->toBeString()
        ->and($player->memberships)->toBeArray()->each->toBeString()
        ->and($player->platforms)->each->toBeInstanceOf(PlayerPlatform::class)
        ->and($player->verified)->toBeBool();
});

test('can get player bans', function () {
    MockClient::global([
        GetPlayerBansRequest::class => MockResponse::fixture('player_bans'),
    ]);

    $response = $this->faceit->player()->getBans('fc885a4c-c6a6-4632-a816-c1cefb75fdf7');

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

    $response = $this->faceit->player()->getGameStats($this->playerId, 'cs2');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(GameMatchStats::class)
        ->and($response->items[0]->stats)->toHaveKey('Kills');
});

test('player game stats hydrate stats', function () {
    MockClient::global([
        GetPlayerGameStatsRequest::class => MockResponse::fixture('player_game_stats'),
    ]);

    $stats = $this->faceit->player()->getGameStats($this->playerId, 'cs2')->items[0];

    expect($stats->stats)->toBeArray();
});

test('can get player matches', function () {
    MockClient::global([
        GetPlayerMatchesRequest::class => MockResponse::fixture('player_matches'),
    ]);

    $response = $this->faceit->player()->getMatches($this->playerId, 'cs2');

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(MatchSummary::class)
        ->and($response->items[0]->teams)->toContainOnlyInstancesOf(MatchSummaryTeam::class)
        ->and($response->items[0]->teams[0]->players)->toContainOnlyInstancesOf(MatchSummaryPlayer::class)
        ->and($response->items[0]->teams[0]->players[0]->gamePlayerId)->toBeString()
        ->and($response->from)->toBe(0)
        ->and($response->to)->toBeInt()->toBeGreaterThan(0)
        ->and($response->start)->toBe(0)
        ->and($response->end)->toBe(20);
});

test('player matches hydrate all attributes', function () {
    MockClient::global([
        GetPlayerMatchesRequest::class => MockResponse::fixture('player_matches'),
    ]);

    $response = $this->faceit->player()->getMatches($this->playerId, 'cs2');

    expect($response->items)->toContainOnlyInstancesOf(MatchSummary::class);

    foreach ($response->items as $match) {
        $team = $match->teams[0];
        $player = $team->players[0];

        expect($match->uuid)->toBeString()->not->toBeEmpty()
            ->and($match->competitionId)->not->toBeEmpty()
            ->and($match->competitionName)->toBeString()->not->toBeEmpty()
            ->and($match->competitionType)->toBeIn(CompetitionType::cases())
            ->and($match->status)->toBeIn(MatchStatus::cases())
            ->and($match->gameId)->toBeString()->not->toBeEmpty()
            ->and($match->gameMode)->toBeString()->not->toBeEmpty()
            ->and($match->matchType)->toBeString()
            ->and($match->maxPlayers)->toBeInt()
            ->and($match->organizerId)->toBeString()->not->toBeEmpty()
            ->and($match->region)->toBeIn(Region::cases())
            ->and($match->faceitUrl)->toBeUrl()
            ->and($match->startedAt)->toBeInstanceOf(DateTime::class)
            ->and($match->startedAt->getTimestamp())->toBeGreaterThan(0)
            ->and($match->finishedAt)->toBeInstanceOf(DateTime::class)
            ->and($match->finishedAt->getTimestamp())->toBeGreaterThan(0)
            ->and($match->results->winner)->toBeIn(['faction1', 'faction2'])
            ->and($match->results->score->byFaction)->toBeArray()
            ->and($match->playingPlayers)->each->toBeUuid();

        foreach ($match->teams as $team) {
            expect($team->uuid)->toBeUuid()
                ->and($team->nickname)->toBeString()->not->toBeEmpty()
                ->and($team->avatar)->toBeUrl();

            foreach ($team->players as $player) {
                expect($player->uuid)->toBeUuid()
                    ->and($player->nickname)->toBeString()->not->toBeEmpty()
                    ->and($player->avatar)->toBeString()
                    ->and($player->faceitUrl)->toBeUrl()
                    ->and($player->gamePlayerId)->toBeString()
                    ->and($player->gamePlayerName)->toBeString();
            }
        }
    }
});

test('can get player hubs', function () {
    MockClient::global([
        GetPlayerHubsRequest::class => MockResponse::fixture('player_hubs'),
    ]);

    $response = $this->faceit->player()->getHubs($this->playerId);

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Hub::class);

    foreach ($response->items as $hub) {
        expect($hub->uuid)->toBeUuid()
            ->and($hub->name)->toBeString()
            ->and($hub->avatar)->toBeUrl()
            ->and($hub->faceitUrl)->toBeUrl()
            ->and($hub->gameId)->toBeString()
            ->and($hub->organizerId)->toBeString();
    }
});

test('player hubs hydrate all attributes', function () {
    MockClient::global([
        GetPlayerHubsRequest::class => MockResponse::fixture('player_hubs'),
    ]);

    $hubs = $this->faceit->player()->getHubs($this->playerId)->items;

    foreach ($hubs as $hub) {
        expect($hub->uuid)->toBeString()
            ->and($hub->name)->toBeString()
            ->and($hub->avatar)->toBeString()
            ->and($hub->faceitUrl)->toBeString()
            ->and($hub->gameId)->toBeString();
    }
});

test('can get player lifetime stats', function () {
    MockClient::global([
        GetPlayerLifetimeStatsRequest::class => MockResponse::fixture('player_lifetime_stats'),
    ]);

    $stats = $this->faceit->player()->getStats($this->playerId, 'cs2');

    expect($stats)->toBeInstanceOf(LifetimeStats::class)
        ->and($stats->playerId)->toBe($this->playerId)
        ->and($stats->lifetime)->toBeArray()->not->toBeEmpty();
});

test('can get player teams', function () {
    MockClient::global([
        GetPlayerTeamsRequest::class => MockResponse::fixture('player_teams'),
    ]);

    $response = $this->faceit->player()->getTeams($this->playerId);

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(PlayerTeam::class);

    foreach ($response->items as $team) {
        expect($team->uuid)->toBeUuid()
            ->and($team->name)->toBeString()->not->toBeEmpty()
            ->and($team->nickname)->toBeString()->not->toBeEmpty()
            ->and($team->avatar)->toBeString()
            ->and($team->coverImage)->toBeString()
            ->and($team->description)->toBeString()
            ->and($team->game)->toBeString()->not->toBeEmpty()
            ->and($team->leader)->toBeUuid()
            ->and($team->teamType)->toBeString()
            ->and($team->chatRoomId)->toBeString()
            ->and($team->faceitUrl)->toBeUrl()
            ->and($team->website)->toBeString()
            ->and($team->twitter)->toBeString()
            ->and($team->facebook)->toBeString()
            ->and($team->youtube)->toBeString()
            ->and($team->members)->toBeEmpty();
    }
});

test('can get player tournaments', function () {
    MockClient::global([
        GetPlayerTournamentsRequest::class => MockResponse::fixture('player_tournaments'),
    ]);

    $response = $this->faceit->player()->getTournaments($this->playerId);

    expect($response)->toBeInstanceOf(PaginatedResponse::class)
        ->and($response->items)->toContainOnlyInstancesOf(Tournament::class);
});

test('player tournaments hydrate all attributes', function () {
    MockClient::global([
        GetPlayerTournamentsRequest::class => MockResponse::fixture('player_tournaments'),
    ]);

    $tournaments = $this->faceit->player()->getTournaments($this->playerId)->items;

    foreach ($tournaments as $tournament) {
        expect($tournament->uuid)->toBeUuid()
            ->and($tournament->name)->toBeString()->not->toBeEmpty()
            ->and($tournament->gameId)->toBeString()->not->toBeEmpty()
            ->and($tournament->region)->toBeIn(Region::cases())
            ->and($tournament->status)->toBeIn(ChampionshipStatus::cases())
            ->and($tournament->faceitUrl)->toBeUrl()
            ->and($tournament->featuredImage)->toBeString()
            ->and($tournament->membershipType)->toBeIn(MembershipType::cases())
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

    }
});
