<?php

namespace Philicevic\FaceitPhp\DTO\Team;

readonly class Member
{
    public function __construct(
        public string $uuid,
        public string $nickname,
        public string $avatar,
        public string $faceitUrl,
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
