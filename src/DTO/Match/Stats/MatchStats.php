<?php

namespace Philicevic\FaceitPhp\DTO\Match\Stats;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class MatchStats
{
    use ValidatesFields;

    /**
     * @param  array<Round>  $rounds
     */
    public function __construct(
        public array $rounds,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'rounds' => 'array',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            rounds: array_map(Round::fromArray(...), $d['rounds']),
        ));
    }
}
