<?php

namespace Philicevic\FaceitPhp\DTO\Search;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
        ValidationContext::pushPath('SearchTeam');
        try {
            static::validateData($data);

            return new self(
                teamId: $data['team_id'],
                name: $data['name'],
                game: (string) ($data['game'] ?? ''),
                avatar: (string) ($data['avatar'] ?? ''),
                faceitUrl: (string) ($data['faceit_url'] ?? ''),
                verified: (bool) ($data['verified'] ?? false),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
