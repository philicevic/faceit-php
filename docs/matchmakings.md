# Matchmakings

Access via `$faceit->matchmaking()`.

## Method reference

| Method | Returns |
|---|---|
| `get(string $matchmakingId)` | `Matchmaking\Matchmaking` |

---

## `get`

Fetch matchmaking configuration details by ID.

```php
$matchmaking = $faceit->matchmaking()->get('matchmaking-uuid');

echo $matchmaking->name;

foreach ($matchmaking->queues as $queue) {
    echo $queue->name;
    echo $queue->gameId;
}
```
