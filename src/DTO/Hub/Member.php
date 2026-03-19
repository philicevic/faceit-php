<?php

namespace Philicevic\FaceitPhp\DTO\Hub;

class Member
{
    /**
     * @param  array<string>  $roles
     */
    public function __construct(
        public readonly string $uuid,
        public readonly string $nickname,
        public readonly string $avatar,
        public readonly string $faceitUrl,
        public readonly array $roles,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['user_id'],
            nickname: (string) ($data['nickname'] ?? ''),
            avatar: (string) ($data['avatar'] ?? ''),
            faceitUrl: (string) ($data['faceit_url'] ?? ''),
            roles: $data['roles'] ?? [],
        );
    }
}
