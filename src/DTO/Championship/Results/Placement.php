<?php

namespace Philicevic\FaceitPhp\DTO\Championship\Results;

use Philicevic\FaceitPhp\Enums\PlacementType;
use Philicevic\FaceitPhp\Validation\ValidatesFields;

class Placement
{
    use ValidatesFields;

    public function __construct(
        public string $uuid,
        public string $name,
        public ?PlacementType $type,
    ) {}

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($data) => new self(
            uuid: $data['id'],
            name: $data['name'],
            type: $data['type'] ? PlacementType::from($data['type']) : null,
        ));
    }

    protected static function fieldSchema(): array
    {
        return [
            'uuid' => 'string',
            'name' => 'string',
            'type' => '?'.PlacementType::class,
        ];
    }

    public function isEmpty(): bool
    {
        return empty($this->uuid) && empty($this->name) && is_null($this->type);
    }
}
