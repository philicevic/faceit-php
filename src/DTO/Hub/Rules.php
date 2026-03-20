<?php

namespace Philicevic\FaceitPhp\DTO\Hub;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

readonly class Rules
{
    use ValidatesFields;

    public function __construct(
        public string $uuid,
        public string $name,
        public string $body,
        public string $game,
        public string $organizer,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'rule_id' => 'string',
            'name' => '?string',
            'body' => '?string',
            'game' => '?string',
            'organizer' => '?string',
        ];
    }

    public static function fromArray(array $data): self
    {
        ValidationContext::pushPath('Rules');
        try {
            static::validateData($data);

            return new self(
                uuid: $data['rule_id'],
                name: (string) ($data['name'] ?? ''),
                body: (string) ($data['body'] ?? ''),
                game: (string) ($data['game'] ?? ''),
                organizer: (string) ($data['organizer'] ?? ''),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
