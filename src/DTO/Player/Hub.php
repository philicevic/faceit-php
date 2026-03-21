<?php

namespace Philicevic\FaceitPhp\DTO\Player;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class Hub
{
    use ValidatesFields;

    public function __construct(
        public string $uuid,
        public string $name,
        public string $avatar,
        public string $coverImage,
        public string $backgroundImage,
        public string $faceitUrl,
        public string $description,
        public string $gameId,
        public string $region,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'hub_id' => 'string',
            'name' => 'string',
            'avatar' => '?string',
            'cover_image' => '?string',
            'background_image' => '?string',
            'faceit_url' => '?string',
            'description' => '?string',
            'game_id' => '?string',
            'region' => '?string',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            uuid: $d['hub_id'],
            name: $d['name'],
            avatar: (string) ($d['avatar'] ?? ''),
            coverImage: (string) ($d['cover_image'] ?? ''),
            backgroundImage: (string) ($d['background_image'] ?? ''),
            faceitUrl: (string) ($d['faceit_url'] ?? ''),
            description: (string) ($d['description'] ?? ''),
            gameId: (string) ($d['game_id'] ?? ''),
            region: (string) ($d['region'] ?? ''),
        ));
    }
}
