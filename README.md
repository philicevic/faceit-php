# faceit-php

A PHP SDK for the [FACEIT Data API v4](https://open.faceit.com/) with typed responses and a Saloon-based client.

## Table of contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Getting a FACEIT API token](#getting-a-faceit-api-token)
- [Quick start](#quick-start)
- [Laravel usage](#laravel-usage)
- [Client reference](#client-reference)
- [Player API](#player-api)
  - [Get a player by FACEIT player ID](#get-a-player-by-faceit-player-id)
  - [Lookup a player](#lookup-a-player)
  - [Read a player's game profile](#read-a-players-game-profile)
  - [Get lifetime stats for a game](#get-lifetime-stats-for-a-game)
  - [Get recent match stats for a player in a game](#get-recent-match-stats-for-a-player-in-a-game)
  - [Get player match history](#get-player-match-history)
  - [Get player bans](#get-player-bans)
  - [Get player hubs](#get-player-hubs)
  - [Get player teams](#get-player-teams)
  - [Get player tournaments](#get-player-tournaments)
- [Match API](#match-api)
  - [Get match details](#get-match-details)
  - [Get match stats](#get-match-stats)
- [Tournament API](#tournament-api)
  - [List tournaments](#list-tournaments)
  - [Get tournament details](#get-tournament-details)
  - [Get tournament brackets](#get-tournament-brackets)
  - [Get tournament matches](#get-tournament-matches)
  - [Get tournament teams](#get-tournament-teams)
- [Championship API](#championship-api)
  - [List championships](#list-championships)
  - [Get championship details](#get-championship-details)
  - [Get championship matches](#get-championship-matches)
  - [Get championship results](#get-championship-results)
  - [Get championship subscriptions](#get-championship-subscriptions)
- [Game API](#game-api)
  - [List games](#list-games)
  - [Get game details](#get-game-details)
  - [Get parent game](#get-parent-game)
  - [Get game matchmakings](#get-game-matchmakings)
- [Hub API](#hub-api)
  - [Get hub details](#get-hub-details)
  - [Get hub matches](#get-hub-matches)
  - [Get hub members](#get-hub-members)
  - [Get hub roles](#get-hub-roles)
  - [Get hub rules](#get-hub-rules)
  - [Get hub stats](#get-hub-stats)
- [Leaderboard API](#leaderboard-api)
  - [Get championship leaderboards](#get-championship-leaderboards)
  - [Get championship group ranking](#get-championship-group-ranking)
  - [Get hub leaderboards](#get-hub-leaderboards)
  - [Get hub ranking](#get-hub-ranking)
  - [Get hub season ranking](#get-hub-season-ranking)
  - [Get leaderboard](#get-leaderboard)
  - [Get player ranking in leaderboard](#get-player-ranking-in-leaderboard)
- [League API](#league-api)
  - [Get league details](#get-league-details)
  - [Get league season](#get-league-season)
  - [Get player in league season](#get-player-in-league-season)
- [Matchmaking API](#matchmaking-api)
  - [Get matchmaking details](#get-matchmaking-details)
- [Organizer API](#organizer-api)
  - [Get organizer by name](#get-organizer-by-name)
  - [Get organizer by ID](#get-organizer-by-id)
  - [Get organizer championships](#get-organizer-championships)
  - [Get organizer games](#get-organizer-games)
  - [Get organizer hubs](#get-organizer-hubs)
  - [Get organizer tournaments](#get-organizer-tournaments)
- [Ranking API](#ranking-api)
  - [Get global ranking](#get-global-ranking)
  - [Get player ranking](#get-player-ranking)
- [Team API](#team-api)
  - [Get team details](#get-team-details)
  - [Get team stats](#get-team-stats)
  - [Get team tournaments](#get-team-tournaments)
- [Paginated responses](#paginated-responses)
- [Available methods](#available-methods)
- [Error handling](#error-handling)
- [Testing](#testing)

## Requirements

- PHP 8.3+

## Installation

```bash
composer require philicevic/faceit-php
```

## Getting a FACEIT API token

Create an API key in the FACEIT developer portal and keep it in an environment variable such as `FACEIT_API_TOKEN`.

## Quick start

```php
<?php

use Philicevic\FaceitPhp\Faceit;

$faceit = new Faceit($_ENV['FACEIT_API_TOKEN']);

$player = $faceit->player()->lookup(nickname: 'Darwin');

echo $player->nickname;
echo $player->games['cs2']->faceitElo;
```

## Laravel usage

You can instantiate the client anywhere, but most Laravel apps will want a binding.

Add the token to `.env`:

```dotenv
FACEIT_API_TOKEN=your-token
```

Bind the client in `AppServiceProvider`:

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Philicevic\FaceitPhp\Faceit;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Faceit::class, fn (): Faceit => new Faceit(
            token: (string) config('services.faceit.token'),
        ));
    }
}
```

Add the token to `config/services.php`:

```php
'faceit' => [
    'token' => env('FACEIT_API_TOKEN'),
],
```

Then use it from a controller, action, command, or job:

```php
<?php

namespace App\Http\Controllers;

use Philicevic\FaceitPhp\Faceit;

class ShowFaceitPlayerController
{
    public function __invoke(Faceit $faceit, string $nickname): array
    {
        $player = $faceit->player()->lookup(nickname: $nickname);

        return [
            'nickname' => $player->nickname,
            'country' => $player->country,
            'elo' => $player->games['cs2']->faceitElo ?? null,
        ];
    }
}
```

## Client reference

Create the client once and reuse it:

```php
use Philicevic\FaceitPhp\Faceit;

$faceit = new Faceit('your-faceit-api-token');
```

Available entrypoints:

- `$faceit->player()`
- `$faceit->match()`
- `$faceit->tournament()`
- `$faceit->championship()`
- `$faceit->game()`
- `$faceit->hub()`
- `$faceit->leaderboard()`
- `$faceit->league()`
- `$faceit->matchmaking()`
- `$faceit->organizer()`
- `$faceit->ranking()`
- `$faceit->team()`
- `$faceit->search()`

## Player API

### Get a player by FACEIT player ID

```php
$player = $faceit->player()->get('ffe3566c-9574-4f1b-8012-bf4d42aeb898');

echo $player->nickname;
echo $player->country;
echo $player->verified ? 'verified' : 'not verified';
```

### Lookup a player

Lookup by nickname:

```php
$player = $faceit->player()->lookup(nickname: 'Darwin');
```

Lookup by game-specific player ID:

```php
$player = $faceit->player()->lookup(
    game: 'cs2',
    gamePlayerId: '76561198000000000',
);
```

### Read a player's game profile

The `games` property is keyed by game ID.

```php
$player = $faceit->player()->get('ffe3566c-9574-4f1b-8012-bf4d42aeb898');
$cs2 = $player->games['cs2'] ?? null;

if ($cs2 !== null) {
    echo $cs2->gamePlayerName;
    echo $cs2->skillLevel;
    echo $cs2->faceitElo;
}
```

### Get lifetime stats for a game

```php
$stats = $faceit->player()->getStats('ffe3566c-9574-4f1b-8012-bf4d42aeb898', 'cs2');

echo $stats->lifetime['Matches'] ?? null;
echo $stats->lifetime['Average K/D Ratio'] ?? null;
```

### Get recent match stats for a player in a game

```php
$response = $faceit->player()->getGameStats(
    playerId: 'ffe3566c-9574-4f1b-8012-bf4d42aeb898',
    gameId: 'cs2',
    offset: 0,
    limit: 20,
    from: 1710000000,
    to: 1710100000,
);

foreach ($response->items as $matchStats) {
    echo $matchStats->stats['Kills'] ?? null;
}
```

### Get player match history

`from` and `to` are Unix timestamps.

```php
$response = $faceit->player()->getMatches(
    playerId: 'ffe3566c-9574-4f1b-8012-bf4d42aeb898',
    game: 'cs2',
    from: 1710000000,
    to: 1710100000,
    offset: 0,
    limit: 20,
);

foreach ($response->items as $match) {
    echo $match->competitionName;
    echo $match->results->winner;
}
```

### Get player bans

```php
$response = $faceit->player()->getBans('ffe3566c-9574-4f1b-8012-bf4d42aeb898', offset: 0, limit: 20);

foreach ($response->items as $ban) {
    echo $ban->reason;
    echo $ban->startsAt->format(DATE_ATOM);
}
```

### Get player hubs

```php
$response = $faceit->player()->getHubs('ffe3566c-9574-4f1b-8012-bf4d42aeb898', offset: 0, limit: 50);

foreach ($response->items as $hub) {
    echo $hub->name;
    echo $hub->region;
}
```

### Get player teams

```php
$response = $faceit->player()->getTeams('ffe3566c-9574-4f1b-8012-bf4d42aeb898', offset: 0, limit: 20);

foreach ($response->items as $team) {
    echo $team->name;

    foreach ($team->members as $member) {
        echo $member->nickname;
    }
}
```

### Get player tournaments

```php
$response = $faceit->player()->getTournaments('ffe3566c-9574-4f1b-8012-bf4d42aeb898', offset: 0, limit: 20);

foreach ($response->items as $tournament) {
    echo $tournament->name;
    echo $tournament->startedAt->format(DATE_ATOM);
}
```

## Match API

### Get match details

```php
$match = $faceit->match()->get('1-bb13fd78-e183-4d37-8a4b-ceed67da5265');

echo $match->competitionName;
echo $match->status;
echo $match->results->winner;

foreach ($match->teams as $team) {
    echo $team->name;

    foreach ($team->players as $player) {
        echo $player->nickname;
    }
}
```

### Get match stats

```php
$stats = $faceit->match()->getStats('1-bb13fd78-e183-4d37-8a4b-ceed67da5265');

foreach ($stats->rounds as $round) {
    echo $round->stats['Map'] ?? null;

    foreach ($round->teams as $team) {
        echo $team->stats['Final Score'] ?? null;

        foreach ($team->players as $player) {
            echo $player->nickname;
            echo $player->stats['Kills'] ?? null;
        }
    }
}
```

## Tournament API

### List tournaments

```php
$response = $faceit->tournament()->list(game: 'cs2', region: 'EU', offset: 0, limit: 20);

foreach ($response->items as $tournament) {
    echo $tournament->name;
    echo $tournament->status;
    echo $tournament->startedAt->format(DATE_ATOM);
}
```

### Get tournament details

```php
$tournament = $faceit->tournament()->get('tournament-id');

echo $tournament->name;
echo $tournament->organizerId;
echo $tournament->anticheatRequired ? 'anticheat required' : 'no anticheat';
echo $tournament->startedAt->format(DATE_ATOM);
```

Optionally expand related objects (`organizer`, `game`):

```php
$tournament = $faceit->tournament()->get('tournament-id', expanded: 'organizer,game');
```

### Get tournament brackets

```php
$brackets = $faceit->tournament()->getBrackets('tournament-id');

echo $brackets->name;
echo $brackets->status;

foreach ($brackets->rounds as $round) {
    echo $round->label;
    echo $round->bestOf;
}

foreach ($brackets->matches as $match) {
    echo $match->state;
    echo $match->results?->winner;
}
```

### Get tournament matches

```php
$response = $faceit->tournament()->getMatches('tournament-id', offset: 0, limit: 20);

foreach ($response->items as $match) {
    echo $match->competitionName;
    echo $match->status;
    echo $match->results->winner;

    foreach ($match->teams as $team) {
        echo $team->name;

        foreach ($team->players as $player) {
            echo $player->nickname;
        }
    }
}
```

### Get tournament teams

Teams are grouped by their registration status.

```php
$teams = $faceit->tournament()->getTeams('tournament-id');

foreach ($teams->checkedIn as $team) {
    echo $team->nickname;
    echo $team->skillLevel;
}

foreach ($teams->joined as $team) {
    echo $team->nickname;
}

// Also available: $teams->started, $teams->finished
```

## Championship API

### List championships

```php
$response = $faceit->championship()->list(game: 'cs2', type: 'ongoing', offset: 0, limit: 10);

foreach ($response->items as $championship) {
    echo $championship->name;
    echo $championship->status;
}
```

### Get championship details

```php
$championship = $faceit->championship()->get('championship-id');

echo $championship->name;
echo $championship->status;
```

Optionally expand related objects (`organizer`, `game`):

```php
$championship = $faceit->championship()->get('championship-id', expanded: 'organizer,game');
```

### Get championship matches

```php
$response = $faceit->championship()->getMatches('championship-id', offset: 0, limit: 20);

foreach ($response->items as $match) {
    echo $match->competitionName;
    echo $match->status;
}
```

### Get championship results

```php
$response = $faceit->championship()->getResults('championship-id', offset: 0, limit: 20);

foreach ($response->items as $result) {
    echo $result->competitionName;
}
```

### Get championship subscriptions

```php
$response = $faceit->championship()->getSubscriptions('championship-id', offset: 0, limit: 10);

foreach ($response->items as $subscription) {
    echo $subscription->status;
}
```

## Game API

### List games

```php
$response = $faceit->game()->list(offset: 0, limit: 20);

foreach ($response->items as $game) {
    echo $game->gameId;
    echo $game->longLabel;
}
```

### Get game details

```php
$game = $faceit->game()->get('cs2');

echo $game->gameId;
echo $game->longLabel;
```

### Get parent game

For region-specific games, fetch the parent:

```php
$parent = $faceit->game()->getParent('cs2-eu');

echo $parent->gameId;
```

### Get game matchmakings

```php
$response = $faceit->game()->getMatchmakings('cs2', region: 'EU', offset: 0, limit: 20);

foreach ($response->items as $matchmaking) {
    echo $matchmaking->label;
    echo $matchmaking->region;
}
```

## Hub API

### Get hub details

```php
$hub = $faceit->hub()->get('hub-id');

echo $hub->name;
echo $hub->region;
```

Optionally expand related objects (`organizer`, `game`):

```php
$hub = $faceit->hub()->get('hub-id', expanded: 'organizer,game');
```

### Get hub matches

```php
$response = $faceit->hub()->getMatches('hub-id', type: 'ongoing', offset: 0, limit: 20);

foreach ($response->items as $match) {
    echo $match->competitionName;
    echo $match->status;
}
```

### Get hub members

```php
$response = $faceit->hub()->getMembers('hub-id', offset: 0, limit: 20);

foreach ($response->items as $member) {
    echo $member->nickname;
}
```

### Get hub roles

```php
$response = $faceit->hub()->getRoles('hub-id', offset: 0, limit: 20);

foreach ($response->items as $role) {
    echo $role->name;
}
```

### Get hub rules

```php
$rules = $faceit->hub()->getRules('hub-id');

echo $rules->body;
```

### Get hub stats

```php
$response = $faceit->hub()->getStats('hub-id', offset: 0, limit: 20);

foreach ($response->items as $stat) {
    echo $stat->nickname;
}
```

## Leaderboard API

### Get championship leaderboards

```php
$response = $faceit->leaderboard()->getChampionshipLeaderboards('championship-id', offset: 0, limit: 20);

foreach ($response->items as $leaderboard) {
    echo $leaderboard->leaderboardId;
}
```

### Get championship group ranking

```php
$ranking = $faceit->leaderboard()->getChampionshipGroupRanking('championship-id', group: 1, offset: 0, limit: 20);

foreach ($ranking->items as $entry) {
    echo $entry->nickname;
    echo $entry->points;
}
```

### Get hub leaderboards

```php
$response = $faceit->leaderboard()->getHubLeaderboards('hub-id', offset: 0, limit: 20);

foreach ($response->items as $leaderboard) {
    echo $leaderboard->leaderboardId;
}
```

### Get hub ranking

Returns the all-time hub ranking.

```php
$ranking = $faceit->leaderboard()->getHubRanking('hub-id', offset: 0, limit: 20);

foreach ($ranking->items as $entry) {
    echo $entry->nickname;
    echo $entry->points;
}
```

### Get hub season ranking

```php
$ranking = $faceit->leaderboard()->getHubSeasonRanking('hub-id', season: 3, offset: 0, limit: 20);

foreach ($ranking->items as $entry) {
    echo $entry->nickname;
    echo $entry->points;
}
```

### Get leaderboard

```php
$ranking = $faceit->leaderboard()->get('leaderboard-id', offset: 0, limit: 20);

foreach ($ranking->items as $entry) {
    echo $entry->nickname;
    echo $entry->points;
}
```

### Get player ranking in leaderboard

```php
$ranking = $faceit->leaderboard()->getPlayerRanking('leaderboard-id', 'player-id');

echo $ranking->nickname;
echo $ranking->position;
echo $ranking->points;
```

## League API

### Get league details

```php
$league = $faceit->league()->get('league-id');

echo $league->name;
```

### Get league season

```php
$season = $faceit->league()->getSeason('league-id', 'season-id');

echo $season->label;
```

### Get player in league season

```php
$playerLeague = $faceit->league()->getSeasonPlayer('league-id', 'season-id', 'player-id');

echo $playerLeague->nickname;
```

## Matchmaking API

### Get matchmaking details

```php
$matchmaking = $faceit->matchmaking()->get('matchmaking-id');

echo $matchmaking->label;
echo $matchmaking->region;
```

## Organizer API

### Get organizer by name

```php
$organizer = $faceit->organizer()->getByName('ESL');

echo $organizer->name;
echo $organizer->type;
```

### Get organizer by ID

```php
$organizer = $faceit->organizer()->get('organizer-id');

echo $organizer->name;
echo $organizer->type;
```

### Get organizer championships

```php
$response = $faceit->organizer()->getChampionships('organizer-id', offset: 0, limit: 20);

foreach ($response->items as $championship) {
    echo $championship->name;
}
```

### Get organizer games

```php
$response = $faceit->organizer()->getGames('organizer-id');

foreach ($response->items as $game) {
    echo $game->gameId;
}
```

### Get organizer hubs

```php
$response = $faceit->organizer()->getHubs('organizer-id', offset: 0, limit: 20);

foreach ($response->items as $hub) {
    echo $hub->name;
}
```

### Get organizer tournaments

```php
$response = $faceit->organizer()->getTournaments('organizer-id', type: 'upcoming', offset: 0, limit: 20);

foreach ($response->items as $tournament) {
    echo $tournament->name;
}
```

## Ranking API

### Get global ranking

```php
$response = $faceit->ranking()->getGlobal(
    gameId: 'cs2',
    region: 'EU',
    country: 'DE',
    offset: 0,
    limit: 20,
);

foreach ($response->items as $entry) {
    echo $entry->nickname;
    echo $entry->faceitElo;
    echo $entry->position;
}
```

### Get player ranking

```php
$ranking = $faceit->ranking()->getPlayer(
    gameId: 'cs2',
    region: 'EU',
    playerId: 'player-id',
    country: 'DE',
    limit: 20,
);

echo $ranking->nickname;
echo $ranking->faceitElo;
echo $ranking->position;
```

## Team API

### Get team details

```php
$team = $faceit->team()->get('team-id');

echo $team->name;
echo $team->game;
```

### Get team stats

```php
$stats = $faceit->team()->getStats('team-id', 'cs2');

echo $stats->lifetime['Matches'] ?? null;
echo $stats->lifetime['Win Rate %'] ?? null;
```

### Get team tournaments

```php
$response = $faceit->team()->getTournaments('team-id', offset: 0, limit: 20);

foreach ($response->items as $tournament) {
    echo $tournament->name;
}
```

## Paginated responses

Methods that return collections use `Philicevic\FaceitPhp\DTO\PaginatedResponse`.

You can access:

- `$response->items`
- `$response->start`
- `$response->end`
- `$response->from`
- `$response->to`

Example:

```php
$response = $faceit->player()->getMatches('ffe3566c-9574-4f1b-8012-bf4d42aeb898', 'cs2');

foreach ($response->items as $item) {
    // ...
}

$hasMore = $response->end > $response->start;
```

## Available methods

### `player()`

```php
$faceit->player()->get(string $uuid);
$faceit->player()->lookup(?string $nickname = null, ?string $game = null, ?string $gamePlayerId = null);
$faceit->player()->getBans(string $playerId, int $offset = 0, int $limit = 20);
$faceit->player()->getGameStats(string $playerId, string $gameId, int $offset = 0, int $limit = 20, ?int $from = null, ?int $to = null);
$faceit->player()->getMatches(string $playerId, string $game, ?int $from = null, ?int $to = null, int $offset = 0, int $limit = 20);
$faceit->player()->getHubs(string $playerId, int $offset = 0, int $limit = 50);
$faceit->player()->getStats(string $playerId, string $gameId);
$faceit->player()->getTeams(string $playerId, int $offset = 0, int $limit = 20);
$faceit->player()->getTournaments(string $playerId, int $offset = 0, int $limit = 20);
```

### `match()`

```php
$faceit->match()->get(string $uuid);
$faceit->match()->getStats(string $uuid);
```

### `tournament()`

```php
$faceit->tournament()->list(?string $game = null, ?string $region = null, int $offset = 0, int $limit = 20);
$faceit->tournament()->get(string $tournamentId, ?string $expanded = null);
$faceit->tournament()->getBrackets(string $tournamentId);
$faceit->tournament()->getMatches(string $tournamentId, int $offset = 0, int $limit = 20);
$faceit->tournament()->getTeams(string $tournamentId, int $offset = 0, int $limit = 20);
```

### `championship()`

```php
$faceit->championship()->list(string $game, ?string $type = null, int $offset = 0, int $limit = 10);
$faceit->championship()->get(string $championshipId, ?string $expanded = null);
$faceit->championship()->getMatches(string $championshipId, ?string $type = null, int $offset = 0, int $limit = 20);
$faceit->championship()->getResults(string $championshipId, int $offset = 0, int $limit = 20);
$faceit->championship()->getSubscriptions(string $championshipId, int $offset = 0, int $limit = 10);
```

### `game()`

```php
$faceit->game()->list(int $offset = 0, int $limit = 20);
$faceit->game()->get(string $gameId);
$faceit->game()->getParent(string $gameId);
$faceit->game()->getMatchmakings(string $gameId, ?string $region = null, int $offset = 0, int $limit = 20);
```

### `hub()`

```php
$faceit->hub()->get(string $hubId, ?string $expanded = null);
$faceit->hub()->getMatches(string $hubId, ?string $type = null, int $offset = 0, int $limit = 20);
$faceit->hub()->getMembers(string $hubId, int $offset = 0, int $limit = 20);
$faceit->hub()->getRoles(string $hubId, int $offset = 0, int $limit = 20);
$faceit->hub()->getRules(string $hubId);
$faceit->hub()->getStats(string $hubId, int $offset = 0, int $limit = 20);
```

### `leaderboard()`

```php
$faceit->leaderboard()->getChampionshipLeaderboards(string $championshipId, int $offset = 0, int $limit = 20);
$faceit->leaderboard()->getChampionshipGroupRanking(string $championshipId, int $group, int $offset = 0, int $limit = 20);
$faceit->leaderboard()->getHubLeaderboards(string $hubId, int $offset = 0, int $limit = 20);
$faceit->leaderboard()->getHubRanking(string $hubId, int $offset = 0, int $limit = 20);
$faceit->leaderboard()->getHubSeasonRanking(string $hubId, int $season, int $offset = 0, int $limit = 20);
$faceit->leaderboard()->get(string $leaderboardId, int $offset = 0, int $limit = 20);
$faceit->leaderboard()->getPlayerRanking(string $leaderboardId, string $playerId);
```

### `league()`

```php
$faceit->league()->get(string $leagueId);
$faceit->league()->getSeason(string $leagueId, string $seasonId);
$faceit->league()->getSeasonPlayer(string $leagueId, string $seasonId, string $playerId);
```

### `matchmaking()`

```php
$faceit->matchmaking()->get(string $matchmakingId);
```

### `organizer()`

```php
$faceit->organizer()->getByName(string $name);
$faceit->organizer()->get(string $organizerId);
$faceit->organizer()->getChampionships(string $organizerId, int $offset = 0, int $limit = 20);
$faceit->organizer()->getGames(string $organizerId);
$faceit->organizer()->getHubs(string $organizerId, int $offset = 0, int $limit = 20);
$faceit->organizer()->getTournaments(string $organizerId, ?string $type = null, int $offset = 0, int $limit = 20);
```

### `ranking()`

```php
$faceit->ranking()->getGlobal(string $gameId, string $region, ?string $country = null, int $offset = 0, int $limit = 20);
$faceit->ranking()->getPlayer(string $gameId, string $region, string $playerId, ?string $country = null, int $limit = 20);
```

### `team()`

```php
$faceit->team()->get(string $teamId);
$faceit->team()->getStats(string $teamId, string $gameId);
$faceit->team()->getTournaments(string $teamId, int $offset = 0, int $limit = 20);
```

## Error handling

The package uses Saloon, so request and transport failures are surfaced as exceptions from the underlying HTTP client / Saloon layer.

```php
try {
$player = $faceit->player()->lookup(nickname: 'Darwin');
} catch (\Throwable $exception) {
    report($exception);
}
```

## Testing

Because the client is built on Saloon, you can use Saloon's mocking tools in tests.

```php
use Philicevic\FaceitPhp\Faceit;
use Philicevic\FaceitPhp\Requests\GetPlayerRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

MockClient::global([
    GetPlayerRequest::class => MockResponse::make([
        'player_id' => 'ffe3566c-9574-4f1b-8012-bf4d42aeb898',
        'nickname' => 'Darwin',
        'activated_at' => '2024-01-01T00:00:00+00:00',
        'games' => [],
    ]),
]);

$faceit = new Faceit('test-token');
$player = $faceit->player()->get('ffe3566c-9574-4f1b-8012-bf4d42aeb898');

expect($player->nickname)->toBe('Darwin');
```
