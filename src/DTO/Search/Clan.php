<?php

namespace Philicevic\FaceitPhp\DTO\Search;

use Philicevic\FaceitPhp\Enums\ClanJoinType;
use Philicevic\FaceitPhp\Enums\Region;
use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class Clan
{
    use ValidatesFields;

    public function __construct(
        public string $uuid,
        public string $name,
        public string $game,
        public Region $region,
        public string $type,
        public string $organizerId,
        public int $minSkillLevel,
        public int $maxSkillLevel,
        public int $membersCount,
        public ClanJoinType $joinType,
        public string $avatar,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'id' => 'string',
            'name' => 'string',
            'game' => 'string',
            'type' => 'string',
            'join' => 'string',
            'avatar' => '?string',
            'region' => Region::class,
            'type' => ClanJoinType::class,
            'organizer_id' => 'string',
            'min_skill_level' => 'int',
            'max_skill_level' => 'int',
            'members_count' => 'int',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            uuid: $d['id'],
            name: $d['name'],
            game: $d['game'],
            region: Region::from($d['region']),
            type: $d['type'],
            organizerId: $d['organizer_id'],
            minSkillLevel: (int) $d['min_skill_level'],
            maxSkillLevel: (int) $d['max_skill_level'],
            membersCount: (int) $d['members_count'],
            joinType: ClanJoinType::from($d['join']),
            avatar: $d['avatar'],
        ));
    }
}
