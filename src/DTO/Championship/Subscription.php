<?php

namespace Philicevic\FaceitPhp\DTO\Championship;

use Philicevic\FaceitPhp\DTO\Team\Team;
use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class Subscription
{
    use ValidatesFields;

    /**
     * @param  array<string>  $roster
     * @param  array<string>  $substitutes
     */
    public function __construct(
        public string $coach,
        public string $coleader,
        public int $group,
        public string $leader,
        public array $roster,
        public string $status,
        public array $substitutes,
        public ?Team $team,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'coach' => '?string',
            'coleader' => '?string',
            'group' => '?int',
            'leader' => '?string',
            'roster' => '?array',
            'status' => '?string',
            'substitutes' => '?array',
            'team' => '?array',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            coach: (string) ($d['coach'] ?? ''),
            coleader: (string) ($d['coleader'] ?? ''),
            group: (int) ($d['group'] ?? 0),
            leader: (string) ($d['leader'] ?? ''),
            roster: $d['roster'] ?? [],
            status: (string) ($d['status'] ?? ''),
            substitutes: $d['substitutes'] ?? [],
            team: isset($d['team']) ? Team::fromArray($d['team']) : null,
        ));
    }
}
