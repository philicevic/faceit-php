<?php

namespace Philicevic\FaceitPhp\DTO\Championship\Results;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

class Group
{
    use ValidatesFields;

    /**
     * @param  array<Placement>  $placements
     */
    public function __construct(
        public Bounds $bounds,
        public array $placements,
    ) {}

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            bounds: Bounds::fromArray($d['bounds']),
            placements: array_map(fn ($p) => Placement::fromArray($p), $d['placements']),
        ));
    }

    protected static function fieldSchema(): array
    {
        return [
            'bounds' => Bounds::class,
            'placements' => 'array',
        ];
    }
}
