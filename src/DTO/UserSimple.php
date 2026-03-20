<?php

namespace Philicevic\FaceitPhp\DTO;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
        ValidationContext::pushPath('UserSimple');
        try {
            static::validateData($data);

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
        } finally {
            ValidationContext::popPath();
        }
    }
}
