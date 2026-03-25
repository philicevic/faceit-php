# Rankings

Global and player-specific ELO rankings per game and region.

Access via `$faceit->ranking()`.

## Method reference

| Method | Returns |
|---|---|
| `getGlobal(string $gameId, string $region, ?string $country, int $offset, int $limit)` | `PaginatedResponse<GlobalRankingItem>` |
| `getPlayer(string $gameId, string $region, string $playerId, ?string $country, int $limit)` | `PaginatedResponse<GlobalRankingItem>` |

---

## `getGlobal`

Returns the global leaderboard for a game and region. Optionally filter by country (ISO 3166-1 alpha-2). Max `$limit` is 100.

```php
$response = $faceit->ranking()->getGlobal(
    gameId: 'cs2',
    region: 'EU',
    country: 'DE',
    offset: 0,
    limit: 20,
);

foreach ($response->items as $item) {
    echo $item->position;
    echo $item->nickname;
    echo $item->faceitElo;
    echo $item->gameSkillLevel;
}
```

---

## `getPlayer`

Returns the ranking page centered around a specific player — useful for showing the player's rank in context. Max `$limit` is 100.

```php
$response = $faceit->ranking()->getPlayer(
    gameId: 'cs2',
    region: 'EU',
    playerId: 'ffe3566c-9574-4f1b-8012-bf4d42aeb898',
    country: null,
    limit: 10,
);

foreach ($response->items as $item) {
    echo $item->position;
    echo $item->nickname;
    echo $item->faceitElo;
}
```
