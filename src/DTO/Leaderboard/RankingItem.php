<?php

namespace Philicevic\FaceitPhp\DTO\Leaderboard;

use Philicevic\FaceitPhp\DTO\UserSimple;
use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class RankingItem
{
    use ValidatesFields;

    public function __construct(
        public int $position,
        public int $points,
        public int $played,
        public int $won,
        public int $lost,
        public int $draw,
        public int $currentStreak,
        public float $winRate,
        public UserSimple $player,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'position' => '?int',
            'points' => '?int',
            'played' => '?int',
            'won' => '?int',
            'lost' => '?int',
            'draw' => '?int',
            'current_streak' => '?int',
            'win_rate' => '?float',
            'player' => 'array',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            position: (int) ($d['position'] ?? 0),
            points: (int) ($d['points'] ?? 0),
            played: (int) ($d['played'] ?? 0),
            won: (int) ($d['won'] ?? 0),
            lost: (int) ($d['lost'] ?? 0),
            draw: (int) ($d['draw'] ?? 0),
            currentStreak: (int) ($d['current_streak'] ?? 0),
            winRate: (float) ($d['win_rate'] ?? 0),
            player: UserSimple::fromArray($d['player']),
        ));
    }
}
