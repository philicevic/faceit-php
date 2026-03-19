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
        public string $type,
        public string $faceitUrl,
        public string $facebook,
        public string $twitter,
        public string $twitch,
        public string $vk,
        public string $website,
        public int $followersCount,
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
