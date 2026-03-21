<?php

namespace Philicevic\FaceitPhp\DTO\Matchmaking;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class MatchmakingQueue
{
    use ValidatesFields;

    public function __construct(
        public string $uuid,
        public string $name,
        public bool $open,
        public string $organizerId,
        public bool $paused,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'queue_id' => '?string',
            'name' => '?string',
            'open' => '?bool',
            'organizer_id' => '?string',
            'paused' => '?bool',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            uuid: (string) ($d['queue_id'] ?? ''),
            name: (string) ($d['name'] ?? ''),
            open: (bool) ($d['open'] ?? false),
            organizerId: (string) ($d['organizer_id'] ?? ''),
            paused: (bool) ($d['paused'] ?? false),
        ));
    }
}
