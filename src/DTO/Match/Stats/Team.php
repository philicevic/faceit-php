<?php

namespace Philicevic\FaceitPhp\DTO\Match\Stats;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class Team
{
    use ValidatesFields;

    /**
     * @param  array<string, mixed>  $stats
     * @param  array<Player>  $players
     */
    public function __construct(
        public string $uuid,
        public bool $premade,
        public array $stats,
        public array $players,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'team_id' => 'string',
            'premade' => 'bool',
            'team_stats' => 'array',
            'players' => 'array',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            uuid: $d['team_id'],
            premade: (bool) $d['premade'],
            stats: $d['team_stats'],
            players: array_map(Player::fromArray(...), $d['players']),
        ));
    }
}
