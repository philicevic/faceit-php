<?php

namespace Philicevic\FaceitPhp\DTO;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

readonly class GameProfile
{
    use ValidatesFields;

    /**
     * @param  array<string, mixed>  $regions
     */
    public function __construct(
        public string $gameId,
        public string $gamePlayerId,
        public string $gamePlayerName,
        public string $gameProfileId,
        public string $region,
        public int $skillLevel,
        public string $skillLevelLabel,
        public int $faceitElo,
        public array $regions = [],
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'game_id' => '?string',
            'game_player_id' => '?string',
            'game_player_name' => '?string',
            'game_profile_id' => '?string',
            'region' => '?string',
            'skill_level' => '?int',
            'skill_level_label' => '?string',
            'faceit_elo' => '?int',
            'regions' => '?array',
        ];
    }

    public static function fromArray(array $data, string $gameId = ''): self
    {
        ValidationContext::pushPath('GameProfile');
        try {
            static::validateData($data);

            return new self(
                gameId: $gameId ?: (string) ($data['game_id'] ?? ''),
                gamePlayerId: (string) ($data['game_player_id'] ?? ''),
                gamePlayerName: (string) ($data['game_player_name'] ?? ''),
                gameProfileId: (string) ($data['game_profile_id'] ?? ''),
                region: (string) ($data['region'] ?? ''),
                skillLevel: (int) ($data['skill_level'] ?? 0),
                skillLevelLabel: (string) ($data['skill_level_label'] ?? ''),
                faceitElo: (int) ($data['faceit_elo'] ?? 0),
                regions: is_array($data['regions'] ?? null) ? $data['regions'] : [],
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
