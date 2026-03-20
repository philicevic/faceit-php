<?php

namespace Philicevic\FaceitPhp\DTO\Leaderboard;

use Philicevic\FaceitPhp\DTO\UserSimple;

readonly class RankingItem
{
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

    public static function fromArray(array $data): self
    {
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
    }
}
