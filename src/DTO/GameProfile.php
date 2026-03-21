<?php

namespace Philicevic\FaceitPhp\DTO;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

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
        return static::validated($data, fn ($d) => new self(
            gameId: $gameId ?: (string) ($d['game_id'] ?? ''),
            gamePlayerId: (string) ($d['game_player_id'] ?? ''),
            gamePlayerName: (string) ($d['game_player_name'] ?? ''),
            gameProfileId: (string) ($d['game_profile_id'] ?? ''),
            region: (string) ($d['region'] ?? ''),
            skillLevel: (int) ($d['skill_level'] ?? 0),
            skillLevelLabel: (string) ($d['skill_level_label'] ?? ''),
            faceitElo: (int) ($d['faceit_elo'] ?? 0),
            regions: is_array($d['regions'] ?? null) ? $d['regions'] : [],
        ));
    }
}
