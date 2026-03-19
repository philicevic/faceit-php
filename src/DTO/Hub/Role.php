<?php

namespace Philicevic\FaceitPhp\DTO\Hub;

class Role
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $name,
        public readonly string $color,
        public readonly int $ranking,
        public readonly bool $visibleOnChat,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['role_id'],
            name: (string) ($data['name'] ?? ''),
            color: (string) ($data['color'] ?? ''),
            ranking: (int) ($data['ranking'] ?? 0),
            visibleOnChat: (bool) ($data['visible_on_chat'] ?? false),
        );
    }
}
