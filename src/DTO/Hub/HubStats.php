<?php

namespace Philicevic\FaceitPhp\DTO\Hub;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class HubStats
{
    use ValidatesFields;

    /**
     * @param  array<HubStatsPlayer>  $players
     */
    public function __construct(
        public string $gameId,
        public array $players,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'game_id' => '?string',
            'players' => '?array',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            gameId: (string) ($d['game_id'] ?? ''),
            players: array_map(HubStatsPlayer::fromArray(...), $d['players'] ?? []),
        ));
    }
}
