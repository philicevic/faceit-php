<?php

namespace Philicevic\FaceitPhp\DTO\Leaderboard;

use Philicevic\FaceitPhp\DTO\UserSimple;
use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
        ValidationContext::pushPath('RankingItem');
        try {
            static::validateData($data);

            return new self(
                position: (int) ($data['position'] ?? 0),
                points: (int) ($data['points'] ?? 0),
                played: (int) ($data['played'] ?? 0),
                won: (int) ($data['won'] ?? 0),
                lost: (int) ($data['lost'] ?? 0),
                draw: (int) ($data['draw'] ?? 0),
                currentStreak: (int) ($data['current_streak'] ?? 0),
                winRate: (float) ($data['win_rate'] ?? 0),
                player: UserSimple::fromArray($data['player']),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
