<?php

namespace Philicevic\FaceitPhp\DTO\Player;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
        ValidationContext::pushPath('PlayerHub');
        try {
            static::validateData($data);

            return new self(
                uuid: $data['hub_id'],
                name: $data['name'],
                avatar: (string) ($data['avatar'] ?? ''),
                coverImage: (string) ($data['cover_image'] ?? ''),
                backgroundImage: (string) ($data['background_image'] ?? ''),
                faceitUrl: (string) ($data['faceit_url'] ?? ''),
                description: (string) ($data['description'] ?? ''),
                gameId: (string) ($data['game_id'] ?? ''),
                region: (string) ($data['region'] ?? ''),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
