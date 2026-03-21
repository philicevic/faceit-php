<?php

namespace Philicevic\FaceitPhp\DTO\Tournament;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

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
        return static::validated($data, fn ($d) => new self(
            uuid: $d['team_id'],
            nickname: (string) ($d['nickname'] ?? ''),
            teamLeader: (string) ($d['team_leader'] ?? ''),
            teamType: (string) ($d['team_type'] ?? ''),
            skillLevel: (int) ($d['skill_level'] ?? 0),
            subsDone: (int) ($d['subs_done'] ?? 0),
        ));
    }
}
