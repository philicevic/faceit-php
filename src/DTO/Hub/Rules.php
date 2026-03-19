<?php

namespace Philicevic\FaceitPhp\DTO\Hub;

readonly class Rules
{
    public function __construct(
        public string $ruleId,
        public string $name,
        public string $body,
        public string $game,
        public string $organizer,
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
