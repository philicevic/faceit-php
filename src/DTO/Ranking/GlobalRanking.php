<?php

namespace Philicevic\FaceitPhp\DTO\Ranking;

class GlobalRanking
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $nickname,
        public readonly string $country,
        public readonly int $faceitElo,
        public readonly int $gameSkillLevel,
        public readonly int $position,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['player_id'],
            nickname: (string) ($data['nickname'] ?? ''),
            country: (string) ($data['country'] ?? ''),
            faceitElo: (int) ($data['faceit_elo'] ?? 0),
            gameSkillLevel: (int) ($data['game_skill_level'] ?? 0),
            position: (int) ($data['position'] ?? 0),
        );
    }
}
