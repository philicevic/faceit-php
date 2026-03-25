# Players

Access via `$faceit->player()`.

## Method reference

| Method | Returns |
|---|---|
| `get(string $uuid)` | `Player` |
| `lookup(?string $nickname, ?string $game, ?string $gamePlayerId)` | `Player` |
| `getBans(string $playerId, int $offset, int $limit)` | `PaginatedResponse<Ban>` |
| `getGameStats(string $playerId, string $gameId, int $offset, int $limit, ?int $from, ?int $to)` | `PaginatedResponse<GameMatchStats>` |
| `getMatches(string $playerId, string $game, ?int $from, ?int $to, int $offset, int $limit)` | `PaginatedResponse<Info>` |
| `getHubs(string $playerId, int $offset, int $limit)` | `PaginatedResponse<Hub>` |
| `getStats(string $playerId, string $gameId)` | `LifetimeStats` |
| `getTeams(string $playerId, int $offset, int $limit)` | `PaginatedResponse<Team>` |
| `getTournaments(string $playerId, int $offset, int $limit)` | `PaginatedResponse<Tournament>` |

---

## `get`

Fetch a player by their FACEIT player UUID.

```php
$player = $faceit->player()->get('ffe3566c-9574-4f1b-8012-bf4d42aeb898');

echo $player->uuid;
echo $player->nickname;
echo $player->country;
echo $player->verified ? 'verified' : 'not verified';
```

---

## `lookup`

Look up a player by nickname or by game-specific player ID. At least one parameter is required.

```php
// By nickname
$player = $faceit->player()->lookup(nickname: 's1mple');

// By game player ID (e.g. Steam ID)
$player = $faceit->player()->lookup(
    game: 'cs2',
    gamePlayerId: '76561198034202275',
);
```

### Reading game profiles

The `games` property is keyed by game ID (e.g. `'cs2'`).

```php
$cs2 = $player->games['cs2'] ?? null;

if ($cs2 !== null) {
    echo $cs2->gamePlayerName;
    echo $cs2->skillLevel;
    echo $cs2->faceitElo;
}
```

---

## `getBans`

```php
$response = $faceit->player()->getBans(
    playerId: 'ffe3566c-9574-4f1b-8012-bf4d42aeb898',
    offset: 0,
    limit: 20,
);

foreach ($response->items as $ban) {
    echo $ban->reason;
    echo $ban->startsAt->format(DATE_ATOM);
    echo $ban->endsAt?->format(DATE_ATOM);
}
```

---

## `getGameStats`

Per-match stats for a player in a specific game. `from` and `to` are Unix timestamps.

```php
$response = $faceit->player()->getGameStats(
    playerId: 'ffe3566c-9574-4f1b-8012-bf4d42aeb898',
    gameId: 'cs2',
    offset: 0,
    limit: 20,
    from: 1710000000,
    to: 1720000000,
);

foreach ($response->items as $matchStats) {
    echo $matchStats->stats['Kills'] ?? null;
    echo $matchStats->stats['K/D Ratio'] ?? null;
}
```

---

## `getMatches`

Match history for a player in a specific game. `from` and `to` are Unix timestamps.

```php
$response = $faceit->player()->getMatches(
    playerId: 'ffe3566c-9574-4f1b-8012-bf4d42aeb898',
    game: 'cs2',
    from: 1710000000,
    to: 1720000000,
    offset: 0,
    limit: 20,
);

foreach ($response->items as $match) {
    echo $match->matchId;
    echo $match->competitionName;
    echo $match->status->value;
    echo $match->results->winner;
}
```

---

## `getHubs`

```php
$response = $faceit->player()->getHubs(
    playerId: 'ffe3566c-9574-4f1b-8012-bf4d42aeb898',
    offset: 0,
    limit: 50,
);

foreach ($response->items as $hub) {
    echo $hub->name;
    echo $hub->gameId;
}
```

---

## `getStats`

Lifetime stats for a player in a specific game. Stats are returned as a key/value map — the keys come directly from the FACEIT API and vary by game.

```php
$stats = $faceit->player()->getStats(
    playerId: 'ffe3566c-9574-4f1b-8012-bf4d42aeb898',
    gameId: 'cs2',
);

echo $stats->lifetime['Matches'] ?? null;
echo $stats->lifetime['Win Rate %'] ?? null;
echo $stats->lifetime['Average K/D Ratio'] ?? null;
```

---

## `getTeams`

```php
$response = $faceit->player()->getTeams(
    playerId: 'ffe3566c-9574-4f1b-8012-bf4d42aeb898',
    offset: 0,
    limit: 20,
);

foreach ($response->items as $team) {
    echo $team->name;

    foreach ($team->members as $member) {
        echo $member->nickname;
    }
}
```

---

## `getTournaments`

```php
$response = $faceit->player()->getTournaments(
    playerId: 'ffe3566c-9574-4f1b-8012-bf4d42aeb898',
    offset: 0,
    limit: 20,
);

foreach ($response->items as $tournament) {
    echo $tournament->name;
    echo $tournament->startedAt?->format(DATE_ATOM);
}
```
