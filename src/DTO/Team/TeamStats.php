<?php

namespace Philicevic\FaceitPhp\DTO\Team;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class TeamStats
{
    use ValidatesFields;

    /**
     * @param  array<string, mixed>  $lifetime
     * @param  array<array<string, mixed>>  $segments
     */
    public function __construct(
        public string $teamId,
        public string $gameId,
        public array $lifetime,
        public array $segments,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'team_id' => 'string',
            'game_id' => 'string',
            'lifetime' => '?array',
            'segments' => '?array',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            teamId: $d['team_id'],
            gameId: $d['game_id'],
            lifetime: $d['lifetime'] ?? [],
            segments: $d['segments'] ?? [],
        ));
    }
}
