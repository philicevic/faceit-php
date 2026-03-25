# Paginated responses

Methods that return collections use `Philicevic\FaceitPhp\DTO\PaginatedResponse<T>`.

## Properties

| Property | Type | Description |
|---|---|---|
| `items` | `array<T>` | The current page of results |
| `start` | `int` | Offset of the first item in this page |
| `end` | `int` | Offset of the last item in this page |
| `from` | `?int` | Unix timestamp lower bound (if applicable) |
| `to` | `?int` | Unix timestamp upper bound (if applicable) |

## Iterating items

```php
$response = $faceit->player()->getMatches(
    playerId: 'ffe3566c-9574-4f1b-8012-bf4d42aeb898',
    game: 'cs2',
);

foreach ($response->items as $match) {
    echo $match->matchId;
}
```

`PaginatedResponse` also implements `ArrayAccess`, so you can access items by index:

```php
$first = $response->items[0];
// or
$first = $response[0];
```

## Checking for more pages

```php
$hasMore = count($response->items) === $limit;

// Or use start/end:
$hasMore = $response->end > $response->start;
```

## Fetching the next page

```php
$limit = 20;
$offset = 0;

do {
    $response = $faceit->player()->getMatches(
        playerId: 'ffe3566c-9574-4f1b-8012-bf4d42aeb898',
        game: 'cs2',
        offset: $offset,
        limit: $limit,
    );

    foreach ($response->items as $match) {
        // process...
    }

    $offset += $limit;
} while (count($response->items) === $limit);
```
