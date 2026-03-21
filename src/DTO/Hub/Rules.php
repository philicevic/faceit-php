<?php

namespace Philicevic\FaceitPhp\DTO\Hub;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

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
        return static::validated($data, fn ($d) => new self(
            uuid: $d['rule_id'],
            name: (string) ($d['name'] ?? ''),
            body: (string) ($d['body'] ?? ''),
            game: (string) ($d['game'] ?? ''),
            organizer: (string) ($d['organizer'] ?? ''),
        ));
    }
}
