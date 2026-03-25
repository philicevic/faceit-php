<?php

namespace Philicevic\FaceitPhp\DTO\Game;

use Philicevic\FaceitPhp\Enums\Platform;
use Philicevic\FaceitPhp\Enums\Region;
use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class Game
{
    use ValidatesFields;

    /**
     * @param  array<Platform>  $platforms
     * @param  array<Region>  $regions
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

    protected static function fieldSchema(): array
    {
        return [
            'game_id' => '?string',
            'short_label' => '?string',
            'long_label' => '?string',
            'order' => '?int',
            'parent_game_id' => '?string',
            'platforms' => '?array',
            'regions' => '?array',
            'assets' => '?array',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            uuid: (string) ($d['game_id'] ?? ''),
            shortLabel: (string) ($d['short_label'] ?? ''),
            longLabel: (string) ($d['long_label'] ?? ''),
            order: (int) ($d['order'] ?? 0),
            parentGameId: (string) ($d['parent_game_id'] ?? ''),
            platforms: array_map(fn ($p) => Platform::from($p), $d['platforms']),
            regions: array_map(fn ($p) => Region::fromFlexible($p), $d['regions']),
            assets: GameAssets::fromArray($d['assets'] ?? []),
        ));
    }
}
