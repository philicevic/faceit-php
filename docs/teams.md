# Teams

Access via `$faceit->team()`.

## Method reference

| Method | Returns |
|---|---|
| `get(string $teamId)` | `Team\Team` |
| `getStats(string $teamId, string $gameId)` | `Team\TeamStats` |
| `getTournaments(string $teamId, int $offset, int $limit)` | `PaginatedResponse<Tournament>` |

---

## `get`

```php
$team = $faceit->team()->get('team-uuid');

echo $team->name;
echo $team->game;

foreach ($team->members as $member) {
    echo $member->nickname;
}
```

---

## `getStats`

Returns overall team stats for a specific game. Stats are returned as key/value segments.

```php
$stats = $faceit->team()->getStats('team-uuid', 'cs2');

foreach ($stats->segments as $segment) {
    echo $segment->label;

    foreach ($segment->stats as $key => $value) {
        echo "$key: $value\n";
    }
}
```

---

## `getTournaments`

Max `$limit` is 100.

```php
$response = $faceit->team()->getTournaments(
    teamId: 'team-uuid',
    offset: 0,
    limit: 20,
);

foreach ($response->items as $tournament) {
    echo $tournament->name;
    echo $tournament->startedAt?->format(DATE_ATOM);
}
```
