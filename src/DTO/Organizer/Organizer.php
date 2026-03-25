<?php

namespace Philicevic\FaceitPhp\DTO\Organizer;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class Organizer
{
    use ValidatesFields;

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

    protected static function fieldSchema(): array
    {
        return [
            'organizer_id' => 'string',
            'name' => '?string',
            'avatar' => '?string',
            'cover' => '?string',
            'description' => '?string',
            'faceit_url' => '?string',
            'type' => '?string',
            'followers_count' => '?int',
            'facebook' => '?string',
            'twitter' => '?string',
            'twitch' => '?string',
            'youtube' => '?string',
            'vk' => '?string',
            'website' => '?string',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            uuid: $d['organizer_id'],
            name: (string) ($d['name'] ?? ''),
            avatar: (string) ($d['avatar'] ?? ''),
            cover: (string) ($d['cover'] ?? ''),
            description: (string) ($d['description'] ?? ''),
            faceitUrl: (string) ($d['faceit_url'] ?? ''),
            type: (string) ($d['type'] ?? ''),
            followersCount: (int) ($d['followers_count'] ?? 0),
            facebook: (string) ($d['facebook'] ?? ''),
            twitter: (string) ($d['twitter'] ?? ''),
            twitch: (string) ($d['twitch'] ?? ''),
            youtube: (string) ($d['youtube'] ?? ''),
            vk: (string) ($d['vk'] ?? ''),
            website: (string) ($d['website'] ?? ''),
        ));
    }
}
