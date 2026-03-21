<?php

namespace Philicevic\FaceitPhp\DTO\Search;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

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
        return static::validated($data, fn ($d) => new self(
            clanId: $d['id'],
            name: $d['name'],
            game: (string) ($d['game'] ?? ''),
            avatar: (string) ($d['avatar'] ?? ''),
            region: (string) ($d['region'] ?? ''),
            membersCount: (int) ($d['members_count'] ?? 0),
        ));
    }
}
