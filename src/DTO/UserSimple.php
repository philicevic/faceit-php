<?php

namespace Philicevic\FaceitPhp\DTO;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class UserSimple
{
    use ValidatesFields;

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

    protected static function fieldSchema(): array
    {
        return [
            'user_id' => 'string',
            'nickname' => 'string',
            'avatar' => '?string',
            'country' => '?string',
            'faceit_url' => '?string',
            'membership_type' => '?string',
            'memberships' => '?array',
            'skill_level' => '?int',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            uuid: $d['user_id'],
            nickname: $d['nickname'],
            avatar: (string) ($d['avatar'] ?? ''),
            country: (string) ($d['country'] ?? ''),
            faceitUrl: (string) ($d['faceit_url'] ?? ''),
            membershipType: (string) ($d['membership_type'] ?? ''),
            memberships: $d['memberships'] ?? [],
            skillLevel: (int) ($d['skill_level'] ?? 0),
        ));
    }
}
