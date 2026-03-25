# Laravel integration

The `Faceit` client has no framework dependencies and works anywhere PHP runs, but most Laravel apps will want a singleton binding.

## 1. Add the token to `.env`

```dotenv
FACEIT_API_TOKEN=your-server-side-api-token
```

## 2. Register in `config/services.php`

```php
'faceit' => [
    'token' => env('FACEIT_API_TOKEN'),
],
```

## 3. Bind in `AppServiceProvider`

```php
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Philicevic\FaceitPhp\Faceit;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Faceit::class, fn (): Faceit => new Faceit(
            token: (string) config('services.faceit.token'),
        ));
    }
}
```

## 4. Inject and use

In a controller:

```php
<?php

namespace App\Http\Controllers;

use Philicevic\FaceitPhp\Faceit;

class PlayerController
{
    public function show(Faceit $faceit, string $nickname): array
    {
        $player = $faceit->player()->lookup(nickname: $nickname);

        return [
            'nickname' => $player->nickname,
            'country' => $player->country,
            'elo' => $player->games['cs2']->faceitElo ?? null,
        ];
    }
}
```

In a job or action:

```php
<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Philicevic\FaceitPhp\Faceit;

class SyncPlayerStats implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly string $playerId) {}

    public function handle(Faceit $faceit): void
    {
        $stats = $faceit->player()->getStats($this->playerId, 'cs2');

        // store $stats->lifetime['Matches'], etc.
    }
}
```
