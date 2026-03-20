<?php

namespace Philicevic\FaceitPhp\DTO;

readonly class UserSimple
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
        public array $memberships,
        public int $skillLevel,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['user_id'],
            nickname: $data['nickname'],
            avatar: (string) ($data['avatar'] ?? ''),
            country: (string) ($data['country'] ?? ''),
            faceitUrl: (string) ($data['faceit_url'] ?? ''),
            membershipType: (string) ($data['membership_type'] ?? ''),
            memberships: $data['memberships'] ?? [],
            skillLevel: (int) ($data['skill_level'] ?? 0),
        );
    }
}
