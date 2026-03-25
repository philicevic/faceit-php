<?php

namespace Philicevic\FaceitPhp\DTO\Player;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class GameMatchStats
{
    use ValidatesFields;

    /**
     * @param  array<string, mixed>  $stats
     */
    public function __construct(
        public array $stats,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'stats' => '?array',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(stats: $d['stats'] ?? []));
    }
}
