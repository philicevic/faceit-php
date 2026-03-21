<?php

namespace Philicevic\FaceitPhp\DTO\Player;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class LifetimeStats
{
    use ValidatesFields;

    /**
     * @param  array<string, mixed>  $lifetime
     * @param  array<array<string, mixed>>  $segments
     */
    public function __construct(
        public string $playerId,
        public string $gameId,
        public array $lifetime,
        public array $segments,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'player_id' => 'string',
            'game_id' => 'string',
            'lifetime' => '?array',
            'segments' => '?array',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            playerId: $d['player_id'],
            gameId: $d['game_id'],
            lifetime: $d['lifetime'] ?? [],
            segments: $d['segments'] ?? [],
        ));
    }
}
