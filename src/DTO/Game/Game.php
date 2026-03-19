<?php

namespace Philicevic\FaceitPhp\DTO\Game;

class Game
{
    /**
     * @param  array<string>  $platforms
     * @param  array<string>  $regions
     */
    public function __construct(
        public readonly string $gameId,
        public readonly string $longLabel,
        public readonly string $shortLabel,
        public readonly string $parentGameId,
        public readonly int $order,
        public readonly array $platforms,
        public readonly array $regions,
        public readonly Assets $assets,
    ) {}

    public static function fromArray(array $data): self
    {
        $a = $data['assets'] ?? [];

        return new self(
            gameId: $data['game_id'],
            longLabel: (string) ($data['long_label'] ?? ''),
            shortLabel: (string) ($data['short_label'] ?? ''),
            parentGameId: (string) ($data['parent_game_id'] ?? ''),
            order: (int) ($data['order'] ?? 0),
            platforms: $data['platforms'] ?? [],
            regions: $data['regions'] ?? [],
            assets: new Assets(
                cover: (string) ($a['cover'] ?? ''),
                featuredImgL: (string) ($a['featured_img_l'] ?? ''),
                featuredImgM: (string) ($a['featured_img_m'] ?? ''),
                featuredImgS: (string) ($a['featured_img_s'] ?? ''),
                flagImgIcon: (string) ($a['flag_img_icon'] ?? ''),
                flagImgL: (string) ($a['flag_img_l'] ?? ''),
                flagImgM: (string) ($a['flag_img_m'] ?? ''),
                flagImgS: (string) ($a['flag_img_s'] ?? ''),
                landingPage: (string) ($a['landing_page'] ?? ''),
            ),
        );
    }
}
