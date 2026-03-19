<?php

namespace Philicevic\FaceitPhp\DTO\Team;

class Member
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $nickname,
        public readonly string $avatar,
        public readonly string $faceitUrl,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['user_id'],
            nickname: (string) ($data['nickname'] ?? ''),
            avatar: (string) ($data['avatar'] ?? ''),
            faceitUrl: (string) ($data['faceit_url'] ?? ''),
        );
    }
}
