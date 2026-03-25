# Championships

Access via `$faceit->championship()`.

## Method reference

| Method | Returns |
|---|---|
| `list(string $game, ?string $type, int $offset, int $limit)` | `PaginatedResponse<Championship>` |
| `get(string $championshipId, ?string $expanded)` | `Championship` |
| `getMatches(string $championshipId, ?string $type, int $offset, int $limit)` | `PaginatedResponse<Match\Detail\Info>` |
| `getResults(string $championshipId, int $offset, int $limit)` | `PaginatedResponse<Championship\Results\Group>` |
| `getSubscriptions(string $championshipId, int $offset, int $limit)` | `PaginatedResponse<Championship\Subscription>` |

---

## `list`

List championships for a game. `$type` can be `all`, `upcoming`, `ongoing`, or `past`. Max `$limit` is 10.

```php
$response = $faceit->championship()->list(
    game: 'cs2',
    type: 'ongoing',
    offset: 0,
    limit: 10,
);

foreach ($response->items as $championship) {
    echo $championship->name;
    echo $championship->status->value;
    echo $championship->game;
}
```

---

## `get`

Fetch championship details. Optionally expand related objects by passing a comma-separated string — supported values: `organizer`, `game`.

```php
$championship = $faceit->championship()->get('championship-uuid');

echo $championship->name;
echo $championship->status->value;
echo $championship->region;
```

With expansion:

```php
$championship = $faceit->championship()->get('championship-uuid', expanded: 'organizer,game');

echo $championship->organizer?->name;
```

---

## `getMatches`

```php
$response = $faceit->championship()->getMatches(
    championshipId: 'championship-uuid',
    type: 'finished',
    offset: 0,
    limit: 20,
);

foreach ($response->items as $match) {
    echo $match->matchId;
    echo $match->status->value;
    echo $match->results?->winner;
}
```

---

## `getResults`

Returns groups of placements. Max `$limit` is 100.

```php
$response = $faceit->championship()->getResults(
    championshipId: 'championship-uuid',
    offset: 0,
    limit: 20,
);

foreach ($response->items as $group) {
    foreach ($group->placements as $placement) {
        echo $placement->team->name;
        echo $placement->placement;
    }
}
```

---

## `getSubscriptions`

Max `$limit` is 10.

```php
$response = $faceit->championship()->getSubscriptions(
    championshipId: 'championship-uuid',
    offset: 0,
    limit: 10,
);

foreach ($response->items as $subscription) {
    echo $subscription->team?->name;
    echo $subscription->status->value;
}
```
