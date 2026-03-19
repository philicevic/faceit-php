<?php

namespace Philicevic\FaceitPhp\DTO\Game;

readonly class Game
{
    /**
     * @param  array<string>  $platforms
     * @param  array<string>  $regions
     */
    public function __construct(
        public string $gameId,
        public string $longLabel,
        public string $shortLabel,
        public string $parentGameId,
        public int $order,
        public array $platforms,
        public array $regions,
        public Assets $assets,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            gameId: $data['game_id'],
            longLabel: (string) ($data['long_label'] ?? ''),
            shortLabel: (string) ($data['short_label'] ?? ''),
            parentGameId: (string) ($data['parent_game_id'] ?? ''),
            order: (int) ($data['order'] ?? 0),
            platforms: $data['platforms'] ?? [],
            regions: $data['regions'] ?? [],
            assets: Assets::fromArray($data['assets'] ?? []),
        );
    }
}
