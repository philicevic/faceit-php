# Matches

Access via `$faceit->match()`.

## Method reference

| Method | Returns |
|---|---|
| `get(string $uuid)` | `Match\Detail\Info` |
| `getStats(string $uuid)` | `Match\Stats\MatchStats` |

---

## `get`

Fetch full match details including teams, players, and result.

```php
$match = $faceit->match()->get('1-bb13fd78-e183-4d37-8a4b-ceed67da5265');

echo $match->matchId;
echo $match->competitionName;
echo $match->status->value;
echo $match->results?->winner;

foreach ($match->teams as $team) {
    echo $team->name;

    foreach ($team->players as $player) {
        echo $player->nickname;
        echo $player->skillLevel;
    }
}
```

---

## `getStats`

Fetch per-round statistics for a match. Stats are returned as key/value maps — keys come directly from the FACEIT API and vary by game.

```php
$stats = $faceit->match()->getStats('1-bb13fd78-e183-4d37-8a4b-ceed67da5265');

foreach ($stats->rounds as $round) {
    echo $round->stats['Map'] ?? null;
    echo $round->stats['Winner'] ?? null;

    foreach ($round->teams as $team) {
        echo $team->stats['Final Score'] ?? null;

        foreach ($team->players as $player) {
            echo $player->nickname;
            echo $player->stats['Kills'] ?? null;
            echo $player->stats['Deaths'] ?? null;
            echo $player->stats['K/D Ratio'] ?? null;
        }
    }
}
```
