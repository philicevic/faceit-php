# Testing

The SDK is built on [Saloon](https://docs.saloon.dev/), which provides a first-class mocking system. No real HTTP calls are made in tests.

## The `faceitMock` helper

The `faceitMock()` helper (defined in `tests/Pest.php`) creates a `Faceit` instance with a fresh mock state. Use it as the starting point in all tests.

```php
$faceit = faceitMock();
```

## Using fixtures

Fixture JSON files live in `tests/Fixtures/Saloon/`. Saloon loads them automatically by name with `MockResponse::fixture()`.

```php
use Philicevic\FaceitPhp\Requests\GetPlayerRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

test('player details are hydrated', function () {
    MockClient::global([
        GetPlayerRequest::class => MockResponse::fixture('player_details'),
    ]);

    $player = faceitMock()->player()->get('ffe3566c-9574-4f1b-8012-bf4d42aeb898');

    expect($player->nickname)->toBeString();
    expect($player->country)->toBeString();
});
```

## Using inline responses

For quick one-off tests, you can pass a raw array instead of a fixture file.

```php
use Philicevic\FaceitPhp\Requests\GetPlayerRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

test('player nickname is set', function () {
    MockClient::global([
        GetPlayerRequest::class => MockResponse::make([
            'player_id' => 'ffe3566c-9574-4f1b-8012-bf4d42aeb898',
            'nickname' => 'Darwin',
            'activated_at' => '2024-01-01T00:00:00+00:00',
            'games' => [],
        ]),
    ]);

    $player = faceitMock()->player()->get('ffe3566c-9574-4f1b-8012-bf4d42aeb898');

    expect($player->nickname)->toBe('Darwin');
});
```

## Adding a new endpoint — testing checklist

When adding a new endpoint, follow this pattern:

1. Add a fixture JSON file to `tests/Fixtures/Saloon/` with a realistic API response.
2. Wire the request class to the fixture with `MockClient::global()`.
3. Assert that all DTO properties are correctly hydrated.

```php
use Philicevic\FaceitPhp\Requests\GetMatchDetailsRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

test('match details are hydrated', function () {
    MockClient::global([
        GetMatchDetailsRequest::class => MockResponse::fixture('match_details'),
    ]);

    $match = faceitMock()->match()->get('1-bb13fd78-e183-4d37-8a4b-ceed67da5265');

    expect($match->matchId)->toBeString()
        ->and($match->status)->toBeInstanceOf(\Philicevic\FaceitPhp\Enums\MatchStatus::class)
        ->and($match->teams)->toBeArray();
});
```

## Running tests

```bash
./vendor/bin/pest

# Single file
./vendor/bin/pest tests/FaceitTests/PlayerTest.php
```
