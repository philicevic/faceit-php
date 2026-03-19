<?php

namespace Philicevic\FaceitPhp\DTO\Player;

readonly class Hub
{
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

    public static function fromArray(array $data): self
    {
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
    }
}
