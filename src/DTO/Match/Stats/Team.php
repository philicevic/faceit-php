<?php

namespace Philicevic\FaceitPhp\DTO\Match\Stats;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
        ValidationContext::pushPath('StatsTeam');
        try {
            static::validateData($data);

            return new self(
                uuid: $data['team_id'],
                premade: (bool) $data['premade'],
                stats: $data['team_stats'],
                players: array_map(Player::fromArray(...), $data['players']),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
