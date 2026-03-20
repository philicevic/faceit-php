<?php

namespace Philicevic\FaceitPhp\DTO\Hub;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
        ValidationContext::pushPath('Member');
        try {
            static::validateData($data);

            return new self(
                uuid: $data['user_id'],
                nickname: $data['nickname'],
                avatar: (string) ($data['avatar'] ?? ''),
                faceitUrl: (string) ($data['faceit_url'] ?? ''),
                roles: $data['roles'] ?? [],
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
