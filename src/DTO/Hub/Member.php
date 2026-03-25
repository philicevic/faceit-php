<?php

namespace Philicevic\FaceitPhp\DTO\Hub;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class Member
{
    use ValidatesFields;

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

    protected static function fieldSchema(): array
    {
        return [
            'user_id' => 'string',
            'nickname' => 'string',
            'avatar' => '?string',
            'faceit_url' => '?string',
            'roles' => '?array',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            uuid: $d['user_id'],
            nickname: $d['nickname'],
            avatar: (string) ($d['avatar'] ?? ''),
            faceitUrl: (string) ($d['faceit_url'] ?? ''),
            roles: $d['roles'] ?? [],
        ));
    }
}
