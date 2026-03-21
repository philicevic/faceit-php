<?php

namespace Philicevic\FaceitPhp\DTO\Tournament;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

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
        return static::validated($data, fn ($d) => new self(
            round: (int) ($d['round'] ?? 0),
            label: (string) ($d['label'] ?? ''),
            matchesCount: (int) ($d['matches'] ?? 0),
            bestOf: (int) ($d['best_of'] ?? 0),
            startTime: (int) ($d['start_time'] ?? 0),
            startsAsap: (bool) ($d['starts_asap'] ?? false),
            substitutionTime: (int) ($d['substitution_time'] ?? 0),
            substitutionsAllowed: (bool) ($d['substitutions_allowed'] ?? false),
        ));
    }
}
