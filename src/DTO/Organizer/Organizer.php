<?php

namespace Philicevic\FaceitPhp\DTO\Organizer;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
        ValidationContext::pushPath('Organizer');
        try {
            static::validateData($data);

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
        } finally {
            ValidationContext::popPath();
        }
    }
}
