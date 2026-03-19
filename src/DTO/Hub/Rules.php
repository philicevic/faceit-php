<?php

namespace Philicevic\FaceitPhp\DTO\Hub;

class Rules
{
    public function __construct(
        public readonly string $ruleId,
        public readonly string $name,
        public readonly string $body,
        public readonly string $game,
        public readonly string $organizer,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            ruleId: $data['rule_id'],
            name: (string) ($data['name'] ?? ''),
            body: (string) ($data['body'] ?? ''),
            game: (string) ($data['game'] ?? ''),
            organizer: (string) ($data['organizer'] ?? ''),
        );
    }
}
