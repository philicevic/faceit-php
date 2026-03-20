<?php

namespace Philicevic\FaceitPhp\DTO\Player;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
        ValidationContext::pushPath('GameMatchStats');
        try {
            static::validateData($data);

            return new self(stats: $data['stats'] ?? []);
        } finally {
            ValidationContext::popPath();
        }
    }
}
