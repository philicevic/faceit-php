<?php

namespace Philicevic\FaceitPhp\DTO\Search;

readonly class Team
{
    public function __construct(
        public string $teamId,
        public string $name,
        public string $game,
        public string $avatar,
        public string $faceitUrl,
        public bool $verified,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            teamId: $data['team_id'],
            name: $data['name'],
            game: (string) ($data['game'] ?? ''),
            avatar: (string) ($data['avatar'] ?? ''),
            faceitUrl: (string) ($data['faceit_url'] ?? ''),
            verified: (bool) ($data['verified'] ?? false),
        );
    }
}
