<?php

namespace Philicevic\FaceitPhp\DTO\Game;

readonly class Game
{
    /**
     * @param  array<string>  $platforms
     * @param  array<string>  $regions
     */
    public function __construct(
        public string $uuid,
        public string $shortLabel,
        public string $longLabel,
        public int $order,
        public string $parentGameId,
        public array $platforms,
        public array $regions,
        public GameAssets $assets,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: (string) ($data['game_id'] ?? ''),
            shortLabel: (string) ($data['short_label'] ?? ''),
            longLabel: (string) ($data['long_label'] ?? ''),
            order: (int) ($data['order'] ?? 0),
            parentGameId: (string) ($data['parent_game_id'] ?? ''),
            platforms: $data['platforms'] ?? [],
            regions: $data['regions'] ?? [],
            assets: GameAssets::fromArray($data['assets'] ?? []),
        );
    }
}
