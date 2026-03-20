<?php

namespace Philicevic\FaceitPhp\DTO\Tournament;

readonly class Team
{
    public function __construct(
        public string $uuid,
        public string $nickname,
        public string $teamLeader,
        public string $teamType,
        public int $skillLevel,
        public int $subsDone,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['team_id'],
            nickname: (string) ($data['nickname'] ?? ''),
            teamLeader: (string) ($data['team_leader'] ?? ''),
            teamType: (string) ($data['team_type'] ?? ''),
            skillLevel: (int) ($data['skill_level'] ?? 0),
            subsDone: (int) ($data['subs_done'] ?? 0),
        );
    }
}
