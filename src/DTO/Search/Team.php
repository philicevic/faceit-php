<?php

namespace Philicevic\FaceitPhp\DTO\Search;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class Team
{
    use ValidatesFields;

    public function __construct(
        public string $teamId,
        public string $name,
        public string $game,
        public string $avatar,
        public string $faceitUrl,
        public bool $verified,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'team_id' => 'string',
            'name' => 'string',
            'game' => '?string',
            'avatar' => '?string',
            'faceit_url' => '?string',
            'verified' => '?bool',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            teamId: $d['team_id'],
            name: $d['name'],
            game: (string) ($d['game'] ?? ''),
            avatar: (string) ($d['avatar'] ?? ''),
            faceitUrl: (string) ($d['faceit_url'] ?? ''),
            verified: (bool) ($d['verified'] ?? false),
        ));
    }
}
