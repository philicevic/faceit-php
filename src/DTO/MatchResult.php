<?php

namespace Philicevic\FaceitPhp\DTO;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
        ValidationContext::pushPath('MatchResult');
        try {
            static::validateData($data);

            return new self(
                winner: $data['winner'],
                score: new MatchScore(byFaction: $data['score']),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
