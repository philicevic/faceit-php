<?php

namespace Philicevic\FaceitPhp\DTO\Championship;

class Subscription
{
    /**
     * @param  array<string>  $roster
     * @param  array<string>  $substitutes
     */
    public function __construct(
        public readonly string $status,
        public readonly string $leader,
        public readonly string $coleader,
        public readonly string $coach,
        public readonly int $group,
        public readonly array $roster,
        public readonly array $substitutes,
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
