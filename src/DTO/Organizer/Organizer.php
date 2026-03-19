<?php

namespace Philicevic\FaceitPhp\DTO\Organizer;

class Organizer
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $name,
        public readonly string $avatar,
        public readonly string $cover,
        public readonly string $description,
        public readonly string $type,
        public readonly string $faceitUrl,
        public readonly string $facebook,
        public readonly string $twitter,
        public readonly string $twitch,
        public readonly string $vk,
        public readonly string $website,
        public readonly int $followersCount,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['organizer_id'],
            name: (string) ($data['name'] ?? ''),
            avatar: (string) ($data['avatar'] ?? ''),
            cover: (string) ($data['cover'] ?? ''),
            description: (string) ($data['description'] ?? ''),
            type: (string) ($data['type'] ?? ''),
            faceitUrl: (string) ($data['faceit_url'] ?? ''),
            facebook: (string) ($data['facebook'] ?? ''),
            twitter: (string) ($data['twitter'] ?? ''),
            twitch: (string) ($data['twitch'] ?? ''),
            vk: (string) ($data['vk'] ?? ''),
            website: (string) ($data['website'] ?? ''),
            followersCount: (int) ($data['followers_count'] ?? 0),
        );
    }
}
