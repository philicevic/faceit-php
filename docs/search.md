# Search

The `search` method is a top-level method on the `Faceit` connector — not on a resource accessor.

```php
$faceit->search(
    query: string,
    type: SearchType,
    offset: int = 0,
    limit: int = 20,
    filters: array = [],
): PaginatedResponse
```

---

## Usage

```php
use Philicevic\FaceitPhp\Enums\SearchType;

$response = $faceit->search(
    query: 's1mple',
    type: SearchType::Player,
    offset: 0,
    limit: 20,
);

foreach ($response->items as $player) {
    echo $player->playerId;
    echo $player->nickname;
    echo $player->country;
}
```

---

## Search types

Pass one of the `SearchType` enum cases as `$type`:

| Case | Searches |
|---|---|
| `SearchType::Player` | Players by nickname |
| `SearchType::Team` | Teams by nickname |
| `SearchType::Hub` | Hubs by name |
| `SearchType::Championship` | Championships by name |
| `SearchType::Tournament` | Tournaments by name |
| `SearchType::Organizer` | Organizers by name |
| `SearchType::Clan` | Clans by name |

---

## Filters

The `$filters` array supports additional query parameters depending on the search type. Pass them as key/value pairs.

| Type | Supported filter keys |
|---|---|
| `Player` | `game`, `country` |
| `Team` | `game` |
| `Hub` | `game`, `region` |
| `Championship` | `game`, `region`, `type` |
| `Tournament` | `game`, `region`, `type` |
| `Clan` | `game`, `region` |
| `Organizer` | (none) |

Example:

```php
$response = $faceit->search(
    query: 'pro',
    type: SearchType::Hub,
    filters: [
        'game' => 'cs2',
        'region' => 'EU',
    ],
);
```
