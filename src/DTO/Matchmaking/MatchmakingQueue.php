<?php

namespace Philicevic\FaceitPhp\DTO\Matchmaking;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
        ValidationContext::pushPath('MatchmakingQueue');
        try {
            static::validateData($data);

            return new self(
                uuid: (string) ($data['queue_id'] ?? ''),
                name: (string) ($data['name'] ?? ''),
                open: (bool) ($data['open'] ?? false),
                organizerId: (string) ($data['organizer_id'] ?? ''),
                paused: (bool) ($data['paused'] ?? false),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
