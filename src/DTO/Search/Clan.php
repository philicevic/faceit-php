<?php

namespace Philicevic\FaceitPhp\DTO\Search;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

readonly class Clan
{
    use ValidatesFields;

    public function __construct(
        public string $clanId,
        public string $name,
        public string $game,
        public string $avatar,
        public string $region,
        public int $membersCount,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'id' => 'string',
            'name' => 'string',
            'game' => '?string',
            'avatar' => '?string',
            'region' => '?string',
            'members_count' => '?int',
        ];
    }

    public static function fromArray(array $data): self
    {
        ValidationContext::pushPath('SearchClan');
        try {
            static::validateData($data);

            return new self(
                clanId: $data['id'],
                name: $data['name'],
                game: (string) ($data['game'] ?? ''),
                avatar: (string) ($data['avatar'] ?? ''),
                region: (string) ($data['region'] ?? ''),
                membersCount: (int) ($data['members_count'] ?? 0),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
