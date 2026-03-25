# faceit-php

A PHP SDK for the [FACEIT Data API v4](https://developers.faceit.com/docs/apis/data-api) built on [Saloon](https://docs.saloon.dev/) v3. Returns fully typed, immutable DTOs for every endpoint.

This package is not stable yet. Use at your own risk.

Also, FACEITs API is sometimes inconsistent. This package tries to improve this a bit, but it still has its limitations. 
For example, the complete tournament endpoint is missing because I could not get reliable results from FACEIT.

## Requirements

- PHP 8.3+

## Installation

```bash
composer require philicevic/faceit-php
```

## Getting a FACEIT API token

Create a server-side API key in the [FACEIT Developer Portal](https://developers.faceit.com/) and store it in an environment variable such as `FACEIT_API_TOKEN`.

## Quick start

```php
use Philicevic\FaceitPhp\Faceit;

$faceit = new Faceit($_ENV['FACEIT_API_TOKEN']);

// Look up a player by nickname
$player = $faceit->player()->lookup(nickname: 's1mple');

echo $player->nickname;
echo $player->country;
echo $player->games['cs2']->faceitElo;

// Get match details
$match = $faceit->match()->get('1-bb13fd78-e183-4d37-8a4b-ceed67da5265');

foreach ($match->teams as $team) {
    echo $team->name;
}
```

## Laravel usage

See [docs/laravel.md](docs/laravel.md) for service container binding and injection examples.

## Resources

The client exposes one accessor per resource group. All methods return typed DTOs.

| Accessor | Methods | Documentation |
|---|---|---|
| `$faceit->player()` | `get`, `lookup`, `getBans`, `getGameStats`, `getMatches`, `getHubs`, `getStats`, `getTeams`, `getTournaments` | [docs/players.md](docs/players.md) |
| `$faceit->match()` | `get`, `getStats` | [docs/matches.md](docs/matches.md) |
| `$faceit->championship()` | `list`, `get`, `getMatches`, `getResults`, `getSubscriptions` | [docs/championships.md](docs/championships.md) |
| `$faceit->hub()` | `get`, `getMatches`, `getMembers`, `getRoles`, `getRules`, `getStats` | [docs/hubs.md](docs/hubs.md) |
| `$faceit->team()` | `get`, `getStats`, `getTournaments` | [docs/teams.md](docs/teams.md) |
| `$faceit->organizer()` | `getByName`, `get`, `getChampionships`, `getGames`, `getHubs`, `getTournaments` | [docs/organizers.md](docs/organizers.md) |
| `$faceit->ranking()` | `getGlobal`, `getPlayer` | [docs/rankings.md](docs/rankings.md) |
| `$faceit->leaderboard()` | `getChampionshipLeaderboards`, `getChampionshipGroupRanking`, `getHubLeaderboards`, `getHubRanking`, `get` | [docs/leaderboards.md](docs/leaderboards.md) |
| `$faceit->game()` | `list`, `get` | [docs/games.md](docs/games.md) |
| `$faceit->matchmaking()` | `get` | [docs/matchmakings.md](docs/matchmakings.md) |
| `$faceit->search(...)` | cross-entity search | [docs/search.md](docs/search.md) |

## Paginated responses

Methods that return collections wrap items in a `PaginatedResponse`. See [docs/paginated-responses.md](docs/paginated-responses.md).

## Strict mode

Enable opt-in DTO validation to catch unexpected API changes early. See [docs/strict-mode.md](docs/strict-mode.md).

## Error handling

The client uses Saloon and the `AlwaysThrowOnErrors` plugin, so HTTP errors surface as Saloon exceptions. Catch `\Throwable` or `\Saloon\Exceptions\Request\RequestException` as needed.

## Testing

Built on Saloon's `MockClient` — no real HTTP calls needed in tests. See [docs/testing.md](docs/testing.md).
