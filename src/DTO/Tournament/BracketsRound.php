<?php

namespace Philicevic\FaceitPhp\DTO\Tournament;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

readonly class BracketsRound
{
    use ValidatesFields;

    public function __construct(
        public int $round,
        public string $label,
        public int $matchesCount,
        public int $bestOf,
        public int $startTime,
        public bool $startsAsap,
        public int $substitutionTime,
        public bool $substitutionsAllowed,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'round' => '?int',
            'label' => '?string',
            'matches' => '?int',
            'best_of' => '?int',
            'start_time' => '?int',
            'starts_asap' => '?bool',
            'substitution_time' => '?int',
            'substitutions_allowed' => '?bool',
        ];
    }

    public static function fromArray(array $data): self
    {
        ValidationContext::pushPath('BracketsRound');
        try {
            static::validateData($data);

            return new self(
                round: (int) ($data['round'] ?? 0),
                label: (string) ($data['label'] ?? ''),
                matchesCount: (int) ($data['matches'] ?? 0),
                bestOf: (int) ($data['best_of'] ?? 0),
                startTime: (int) ($data['start_time'] ?? 0),
                startsAsap: (bool) ($data['starts_asap'] ?? false),
                substitutionTime: (int) ($data['substitution_time'] ?? 0),
                substitutionsAllowed: (bool) ($data['substitutions_allowed'] ?? false),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
