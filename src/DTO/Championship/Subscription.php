<?php

namespace Philicevic\FaceitPhp\DTO\Championship;

use Philicevic\FaceitPhp\DTO\Team\Team;

readonly class Subscription
{
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

    public static function fromArray(array $data): self
    {
        return new self(
            coach: (string) ($data['coach'] ?? ''),
            coleader: (string) ($data['coleader'] ?? ''),
            group: (int) ($data['group'] ?? 0),
            leader: (string) ($data['leader'] ?? ''),
            roster: $data['roster'] ?? [],
            status: (string) ($data['status'] ?? ''),
            substitutes: $data['substitutes'] ?? [],
            team: isset($data['team']) ? Team::fromArray($data['team']) : null,
        );
    }
}
