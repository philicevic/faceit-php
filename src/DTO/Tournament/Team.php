<?php

namespace Philicevic\FaceitPhp\DTO\Tournament;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

readonly class Team
{
    use ValidatesFields;

    public function __construct(
        public string $uuid,
        public string $nickname,
        public string $teamLeader,
        public string $teamType,
        public int $skillLevel,
        public int $subsDone,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'team_id' => 'string',
            'nickname' => '?string',
            'team_leader' => '?string',
            'team_type' => '?string',
            'skill_level' => '?int',
            'subs_done' => '?int',
        ];
    }

    public static function fromArray(array $data): self
    {
        ValidationContext::pushPath('TournamentTeam');
        try {
            static::validateData($data);

            return new self(
                uuid: $data['team_id'],
                nickname: (string) ($data['nickname'] ?? ''),
                teamLeader: (string) ($data['team_leader'] ?? ''),
                teamType: (string) ($data['team_type'] ?? ''),
                skillLevel: (int) ($data['skill_level'] ?? 0),
                subsDone: (int) ($data['subs_done'] ?? 0),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
