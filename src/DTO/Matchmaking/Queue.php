<?php

namespace Philicevic\FaceitPhp\DTO\Matchmaking;

class Queue
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $name,
        public readonly string $organizerId,
        public readonly bool $open,
        public readonly bool $paused,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['id'],
            name: (string) ($data['name'] ?? ''),
            organizerId: (string) ($data['organizer_id'] ?? ''),
            open: (bool) ($data['open'] ?? false),
            paused: (bool) ($data['paused'] ?? false),
        );
    }
}
