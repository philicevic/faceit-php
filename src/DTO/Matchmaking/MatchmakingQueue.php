<?php

namespace Philicevic\FaceitPhp\DTO\Matchmaking;

readonly class MatchmakingQueue
{
    public function __construct(
        public string $uuid,
        public string $name,
        public bool $open,
        public string $organizerId,
        public bool $paused,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: (string) ($data['queue_id'] ?? ''),
            name: (string) ($data['name'] ?? ''),
            open: (bool) ($data['open'] ?? false),
            organizerId: (string) ($data['organizer_id'] ?? ''),
            paused: (bool) ($data['paused'] ?? false),
        );
    }
}
