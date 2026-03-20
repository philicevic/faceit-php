<?php

namespace Philicevic\FaceitPhp\DTO\Organizer;

readonly class Organizer
{
    public function __construct(
        public string $uuid,
        public string $name,
        public string $avatar,
        public string $cover,
        public string $description,
        public string $faceitUrl,
        public string $type,
        public int $followersCount,
        public string $facebook,
        public string $twitter,
        public string $twitch,
        public string $youtube,
        public string $vk,
        public string $website,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['organizer_id'],
            name: (string) ($data['name'] ?? ''),
            avatar: (string) ($data['avatar'] ?? ''),
            cover: (string) ($data['cover'] ?? ''),
            description: (string) ($data['description'] ?? ''),
            faceitUrl: (string) ($data['faceit_url'] ?? ''),
            type: (string) ($data['type'] ?? ''),
            followersCount: (int) ($data['followers_count'] ?? 0),
            facebook: (string) ($data['facebook'] ?? ''),
            twitter: (string) ($data['twitter'] ?? ''),
            twitch: (string) ($data['twitch'] ?? ''),
            youtube: (string) ($data['youtube'] ?? ''),
            vk: (string) ($data['vk'] ?? ''),
            website: (string) ($data['website'] ?? ''),
        );
    }
}
