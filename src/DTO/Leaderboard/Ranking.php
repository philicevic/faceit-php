<?php

namespace Philicevic\FaceitPhp\DTO\Leaderboard;

class Ranking
{
    public function __construct(
        public readonly int $position,
        public readonly int $points,
        public readonly int $played,
        public readonly int $won,
        public readonly int $lost,
        public readonly int $draw,
        public readonly int $currentStreak,
        public readonly float $winRate,
        public readonly RankingPlayer $player,
    ) {}

    public static function fromArray(array $data): self
    {
        $p = $data['player'] ?? [];

        return new self(
            position: (int) ($data['position'] ?? 0),
            points: (int) ($data['points'] ?? 0),
            played: (int) ($data['played'] ?? 0),
            won: (int) ($data['won'] ?? 0),
            lost: (int) ($data['lost'] ?? 0),
            draw: (int) ($data['draw'] ?? 0),
            currentStreak: (int) ($data['current_streak'] ?? 0),
            winRate: (float) ($data['win_rate'] ?? 0.0),
            player: new RankingPlayer(
                uuid: $p['user_id'] ?? '',
                nickname: (string) ($p['nickname'] ?? ''),
                avatar: (string) ($p['avatar'] ?? ''),
                country: (string) ($p['country'] ?? ''),
                faceitUrl: (string) ($p['faceit_url'] ?? ''),
                membershipType: (string) ($p['membership_type'] ?? ''),
                skillLevel: (int) ($p['skill_level'] ?? 0),
                memberships: $p['memberships'] ?? [],
            ),
        );
    }
}
