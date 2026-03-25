# Organizers

Access via `$faceit->organizer()`.

## Method reference

| Method | Returns |
|---|---|
| `getByName(string $name)` | `Organizer\Organizer` |
| `get(string $organizerId)` | `Organizer\Organizer` |
| `getChampionships(string $organizerId, ?bool $publishedOnly, int $offset, int $limit, ?string $sort)` | `PaginatedResponse<Championship>` |
| `getGames(string $organizerId)` | `PaginatedResponse<Game>` |
| `getHubs(string $organizerId, int $offset, int $limit)` | `PaginatedResponse<Hub>` |
| `getTournaments(string $organizerId, ?string $type, int $offset, int $limit)` | `PaginatedResponse<Tournament>` |

---

## `getByName`

Look up an organizer by their exact name.

```php
$organizer = $faceit->organizer()->getByName('ESL');

echo $organizer->organizerId;
echo $organizer->name;
```

---

## `get`

Fetch organizer details by UUID.

```php
$organizer = $faceit->organizer()->get('organizer-uuid');

echo $organizer->name;
```

---

## `getChampionships`

Max `$limit` is 100.

```php
$response = $faceit->organizer()->getChampionships(
    organizerId: 'organizer-uuid',
    publishedOnly: true,
    offset: 0,
    limit: 20,
    sort: 'desc',
);

foreach ($response->items as $championship) {
    echo $championship->name;
    echo $championship->status->value;
}
```

---

## `getGames`

```php
$response = $faceit->organizer()->getGames('organizer-uuid');

foreach ($response->items as $game) {
    echo $game->gameId;
    echo $game->longLabel;
}
```

---

## `getHubs`

Max `$limit` is 50.

```php
$response = $faceit->organizer()->getHubs(
    organizerId: 'organizer-uuid',
    offset: 0,
    limit: 20,
);

foreach ($response->items as $hub) {
    echo $hub->name;
    echo $hub->gameId;
}
```

---

## `getTournaments`

Max `$limit` is 100. `$type` can be `upcoming`, `ongoing`, or `past`.

```php
$response = $faceit->organizer()->getTournaments(
    organizerId: 'organizer-uuid',
    type: 'upcoming',
    offset: 0,
    limit: 20,
);

foreach ($response->items as $tournament) {
    echo $tournament->name;
    echo $tournament->startedAt?->format(DATE_ATOM);
}
```
