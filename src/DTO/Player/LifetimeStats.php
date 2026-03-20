<?php

namespace Philicevic\FaceitPhp\DTO\Player;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
        ValidationContext::pushPath('LifetimeStats');
        try {
            static::validateData($data);

            return new self(
                playerId: $data['player_id'],
                gameId: $data['game_id'],
                lifetime: $data['lifetime'] ?? [],
                segments: $data['segments'] ?? [],
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
