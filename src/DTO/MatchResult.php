<?php

namespace Philicevic\FaceitPhp\DTO;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class MatchResult
{
    use ValidatesFields;

    public function __construct(
        public string $winner,
        public MatchScore $score,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'winner' => 'string',
            'score' => 'array',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            winner: $d['winner'],
            score: new MatchScore(byFaction: $d['score']),
        ));
    }
}
