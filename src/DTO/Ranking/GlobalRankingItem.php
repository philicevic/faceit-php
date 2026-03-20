<?php

namespace Philicevic\FaceitPhp\DTO\Ranking;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

readonly class GlobalRankingItem
{
    use ValidatesFields;

    public function __construct(
        public string $uuid,
        public string $nickname,
        public string $country,
        public int $faceitElo,
        public int $gameSkillLevel,
        public int $position,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'player_id' => '?string',
            'nickname' => '?string',
            'country' => '?string',
            'faceit_elo' => '?int',
            'game_skill_level' => '?int',
            'position' => '?int',
        ];
    }

    public static function fromArray(array $data): self
    {
        ValidationContext::pushPath('GlobalRankingItem');
        try {
            static::validateData($data);

            return new self(
                uuid: (string) ($data['player_id'] ?? ''),
                nickname: (string) ($data['nickname'] ?? ''),
                country: (string) ($data['country'] ?? ''),
                faceitElo: (int) ($data['faceit_elo'] ?? 0),
                gameSkillLevel: (int) ($data['game_skill_level'] ?? 0),
                position: (int) ($data['position'] ?? 0),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
