<?php

namespace Philicevic\FaceitPhp\DTO\Game;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class MatchmakingSummary
{
    use ValidatesFields;

    public function __construct(
        public string $uuid,
        public string $name,
        public string $game,
        public string $region,
        public bool $hasLeague,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'matchmaking_id' => '?string',
            'name' => '?string',
            'game' => '?string',
            'region' => '?string',
            'has_league' => '?bool',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            uuid: (string) ($d['matchmaking_id'] ?? ''),
            name: (string) ($d['name'] ?? ''),
            game: (string) ($d['game'] ?? ''),
            region: (string) ($d['region'] ?? ''),
            hasLeague: (bool) ($d['has_league'] ?? false),
        ));
    }
}
