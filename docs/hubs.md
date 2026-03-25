# Hubs

Access via `$faceit->hub()`.

## Method reference

| Method | Returns |
|---|---|
| `get(string $hubId, ?string $expanded)` | `Hub\Hub` |
| `getMatches(string $hubId, ?string $type, int $offset, int $limit)` | `PaginatedResponse<Match\Detail\Info>` |
| `getMembers(string $hubId, int $offset, int $limit)` | `PaginatedResponse<Hub\Member>` |
| `getRoles(string $hubId, int $offset, int $limit)` | `PaginatedResponse<Hub\Role>` |
| `getRules(string $hubId)` | `Hub\Rules` |
| `getStats(string $hubId, int $offset, int $limit)` | `Hub\HubStats` |

---

## `get`

Optionally expand related objects with a comma-separated string — supported values: `organizer`, `game`.

```php
$hub = $faceit->hub()->get('hub-uuid');

echo $hub->name;
echo $hub->gameId;
echo $hub->region;
echo $hub->minSkillLevel;
echo $hub->maxSkillLevel;
```

With expansion:

```php
$hub = $faceit->hub()->get('hub-uuid', expanded: 'organizer,game');

echo $hub->organizer?->name;
```

---

## `getMatches`

Max `$limit` is 100.

```php
$response = $faceit->hub()->getMatches(
    hubId: 'hub-uuid',
    type: 'finished',
    offset: 0,
    limit: 20,
);

foreach ($response->items as $match) {
    echo $match->matchId;
    echo $match->status->value;
}
```

---

## `getMembers`

Max `$offset` is 1000, max `$limit` is 50.

```php
$response = $faceit->hub()->getMembers(
    hubId: 'hub-uuid',
    offset: 0,
    limit: 20,
);

foreach ($response->items as $member) {
    echo $member->userId;
    echo $member->nickname;
}
```

---

## `getRoles`

```php
$response = $faceit->hub()->getRoles(
    hubId: 'hub-uuid',
    offset: 0,
    limit: 20,
);

foreach ($response->items as $role) {
    echo $role->name;
}
```

---

## `getRules`

```php
$rules = $faceit->hub()->getRules('hub-uuid');

echo $rules->body;
```

---

## `getStats`

Returns the hub leaderboard (top players by stats). Max `$limit` is 100.

```php
$stats = $faceit->hub()->getStats(
    hubId: 'hub-uuid',
    offset: 0,
    limit: 20,
);

foreach ($stats->players as $player) {
    echo $player->nickname;
    echo $player->stats['Matches'] ?? null;
    echo $player->stats['Win Rate %'] ?? null;
}
```
