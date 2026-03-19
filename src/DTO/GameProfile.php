<?php

namespace Philicevic\FaceitPhp\DTO;

readonly class GameProfile
{
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

    public static function fromArray(string $gameId, array $data): self
    {
        return new self(
            gameId: $gameId,
            gamePlayerId: (string) ($data['game_player_id'] ?? ''),
            gamePlayerName: (string) ($data['game_player_name'] ?? ''),
            gameProfileId: (string) ($data['game_profile_id'] ?? ''),
            region: (string) ($data['region'] ?? ''),
            skillLevel: (int) ($data['skill_level'] ?? 0),
            skillLevelLabel: (string) ($data['skill_level_label'] ?? ''),
            faceitElo: (int) ($data['faceit_elo'] ?? 0),
            regions: is_array($data['regions'] ?? null) ? $data['regions'] : [],
        );
    }
}
