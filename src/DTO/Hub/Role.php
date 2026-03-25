<?php

namespace Philicevic\FaceitPhp\DTO\Hub;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class Role
{
    use ValidatesFields;

    public function __construct(
        public string $uuid,
        public string $name,
        public string $color,
        public int $ranking,
        public bool $visibleOnChat,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'role_id' => 'string',
            'name' => 'string',
            'color' => '?string',
            'ranking' => '?int',
            'visible_on_chat' => '?bool',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            uuid: $d['role_id'],
            name: $d['name'],
            color: (string) ($d['color'] ?? ''),
            ranking: (int) ($d['ranking'] ?? 0),
            visibleOnChat: (bool) ($d['visible_on_chat'] ?? false),
        ));
    }
}
