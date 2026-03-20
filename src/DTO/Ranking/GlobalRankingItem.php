<?php

namespace Philicevic\FaceitPhp\DTO\Ranking;

readonly class GlobalRankingItem
{
    public function __construct(
        public string $uuid,
        public string $nickname,
        public string $country,
        public int $faceitElo,
        public int $gameSkillLevel,
        public int $position,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: (string) ($data['player_id'] ?? ''),
            nickname: (string) ($data['nickname'] ?? ''),
            country: (string) ($data['country'] ?? ''),
            faceitElo: (int) ($data['faceit_elo'] ?? 0),
            gameSkillLevel: (int) ($data['game_skill_level'] ?? 0),
            position: (int) ($data['position'] ?? 0),
        );
    }
}
