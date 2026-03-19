<?php

namespace Philicevic\FaceitPhp\DTO\Matchmaking;

readonly class Queue
{
    public function __construct(
        public string $uuid,
        public string $name,
        public string $organizerId,
        public bool $open,
        public bool $paused,
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
