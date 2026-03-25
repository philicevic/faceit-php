# Games

Access via `$faceit->game()`.

## Method reference

| Method | Returns |
|---|---|
| `list(int $offset, int $limit)` | `PaginatedResponse<Game>` |
| `get(string $gameId)` | `Game\Game` |

---

## `list`

Returns all games available on FACEIT. Max `$limit` is 100.

```php
$response = $faceit->game()->list(offset: 0, limit: 20);

foreach ($response->items as $game) {
    echo $game->gameId;
    echo $game->longLabel;
    echo $game->shortLabel;
}
```

---

## `get`

Fetch details for a specific game by its ID (e.g. `'cs2'`, `'csgo'`).

```php
$game = $faceit->game()->get('cs2');

echo $game->gameId;
echo $game->longLabel;
echo $game->assets->cover;
echo $game->assets->featured_img_s;
```
