<?php

namespace Philicevic\FaceitPhp\DTO\Ranking;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

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
        return static::validated($data, fn ($d) => new self(
            uuid: (string) ($d['player_id'] ?? ''),
            nickname: (string) ($d['nickname'] ?? ''),
            country: (string) ($d['country'] ?? ''),
            faceitElo: (int) ($d['faceit_elo'] ?? 0),
            gameSkillLevel: (int) ($d['game_skill_level'] ?? 0),
            position: (int) ($d['position'] ?? 0),
        ));
    }
}
