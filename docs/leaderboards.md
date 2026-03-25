# Leaderboards

Access via `$faceit->leaderboard()`.

## Method reference

| Method | Returns |
|---|---|
| `getChampionshipLeaderboards(string $championshipId, int $offset, int $limit)` | `PaginatedResponse<Leaderboard>` |
| `getChampionshipGroupRanking(string $championshipId, int $group, int $offset, int $limit)` | `EntityRanking` |
| `getHubLeaderboards(string $hubId, int $offset, int $limit)` | `PaginatedResponse<Leaderboard>` |
| `getHubRanking(string $hubId, int $offset, int $limit)` | `EntityRanking` |
| `get(string $leaderboardId, int $offset, int $limit)` | `EntityRanking` |

---

## `getChampionshipLeaderboards`

Returns a list of leaderboard metadata for a championship. Max `$limit` is 100.

```php
$response = $faceit->leaderboard()->getChampionshipLeaderboards(
    championshipId: 'championship-uuid',
    offset: 0,
    limit: 20,
);

foreach ($response->items as $leaderboard) {
    echo $leaderboard->leaderboardId;
    echo $leaderboard->name;
}
```

---

## `getChampionshipGroupRanking`

Returns the ranking for a specific group within a championship. `$group` is an integer starting from 1.

```php
$ranking = $faceit->leaderboard()->getChampionshipGroupRanking(
    championshipId: 'championship-uuid',
    group: 1,
    offset: 0,
    limit: 20,
);

foreach ($ranking->items as $item) {
    echo $item->playerId;
    echo $item->nickname;
    echo $item->points;
}
```

---

## `getHubLeaderboards`

Returns a list of leaderboard metadata for a hub. Max `$limit` is 100.

```php
$response = $faceit->leaderboard()->getHubLeaderboards(
    hubId: 'hub-uuid',
    offset: 0,
    limit: 20,
);

foreach ($response->items as $leaderboard) {
    echo $leaderboard->leaderboardId;
    echo $leaderboard->name;
}
```

---

## `getHubRanking`

Returns the all-time ranking for a hub. Max `$limit` is 100.

```php
$ranking = $faceit->leaderboard()->getHubRanking(
    hubId: 'hub-uuid',
    offset: 0,
    limit: 20,
);

foreach ($ranking->items as $item) {
    echo $item->playerId;
    echo $item->nickname;
    echo $item->points;
}
```

---

## `get`

Returns rankings for a specific leaderboard by its ID. Max `$limit` is 100.

```php
$ranking = $faceit->leaderboard()->get(
    leaderboardId: 'leaderboard-uuid',
    offset: 0,
    limit: 20,
);

foreach ($ranking->items as $item) {
    echo $item->playerId;
    echo $item->nickname;
    echo $item->points;
}
```
