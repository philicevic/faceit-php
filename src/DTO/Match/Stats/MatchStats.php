<?php

namespace Philicevic\FaceitPhp\DTO\Match\Stats;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
        ValidationContext::pushPath('MatchStats');
        try {
            static::validateData($data);

            return new self(
                rounds: array_map(Round::fromArray(...), $data['rounds']),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
