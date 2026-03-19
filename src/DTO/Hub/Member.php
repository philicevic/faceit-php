<?php

namespace Philicevic\FaceitPhp\DTO\Hub;

readonly class Member
{
    /**
     * @param  array<string>  $roles
     */
    public function __construct(
        public string $uuid,
        public string $nickname,
        public string $avatar,
        public string $faceitUrl,
        public array $roles,
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
