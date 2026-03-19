<?php

namespace Philicevic\FaceitPhp\DTO\Hub;

readonly class Role
{
    public function __construct(
        public string $uuid,
        public string $name,
        public string $color,
        public int $ranking,
        public bool $visibleOnChat,
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
