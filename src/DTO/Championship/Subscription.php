<?php

namespace Philicevic\FaceitPhp\DTO\Championship;

readonly class Subscription
{
    /**
     * @param  array<string>  $roster
     * @param  array<string>  $substitutes
     */
    public function __construct(
        public string $status,
        public string $leader,
        public string $coleader,
        public string $coach,
        public int $group,
        public array $roster,
        public array $substitutes,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            status: (string) ($data['status'] ?? ''),
            leader: (string) ($data['leader'] ?? ''),
            coleader: (string) ($data['coleader'] ?? ''),
            coach: (string) ($data['coach'] ?? ''),
            group: (int) ($data['group'] ?? 0),
            roster: $data['roster'] ?? [],
            substitutes: $data['substitutes'] ?? [],
        );
    }
}
