<?php

namespace Philicevic\FaceitPhp\DTO\Hub;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
        ValidationContext::pushPath('Role');
        try {
            static::validateData($data);

            return new self(
                uuid: $data['role_id'],
                name: $data['name'],
                color: (string) ($data['color'] ?? ''),
                ranking: (int) ($data['ranking'] ?? 0),
                visibleOnChat: (bool) ($data['visible_on_chat'] ?? false),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
