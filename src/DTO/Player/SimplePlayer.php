<?php

namespace Philicevic\FaceitPhp\DTO\Player;

readonly class SimplePlayer
{
    /**
     * @param  array<string>  $memberships
     */
    public function __construct(
        public string $uuid,
        public string $nickname,
        public string $avatar,
        public string $country,
        public string $faceitUrl,
        public string $membershipType,
        public int $skillLevel,
        public array $memberships,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: (string) ($data['player_id'] ?? $data['user_id'] ?? ''),
            nickname: (string) ($data['nickname'] ?? ''),
            avatar: (string) ($data['avatar'] ?? ''),
            country: (string) ($data['country'] ?? ''),
            faceitUrl: (string) ($data['faceit_url'] ?? ''),
            membershipType: (string) ($data['membership_type'] ?? ''),
            skillLevel: (int) ($data['skill_level'] ?? 0),
            memberships: $data['memberships'] ?? [],
        );
    }
}
