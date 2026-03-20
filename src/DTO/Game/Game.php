<?php

namespace Philicevic\FaceitPhp\DTO\Game;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

readonly class Game
{
    use ValidatesFields;

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
        ValidationContext::pushPath('Game');
        try {
            static::validateData($data);

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
        } finally {
            ValidationContext::popPath();
        }
    }
}
