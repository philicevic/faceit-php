<?php

namespace Philicevic\FaceitPhp\DTO\Tournament;

use Philicevic\FaceitPhp\DTO\MatchResult;
use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

readonly class BracketsMatch
{
    use ValidatesFields;

    public function __construct(
        public string $uuid,
        public string $faceitUrl,
        public int $round,
        public int $position,
        public string $state,
        public ?MatchResult $results,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'match_id' => 'string',
            'faceit_url' => '?string',
            'round' => '?int',
            'position' => '?int',
            'state' => '?string',
            'results' => '?array',
        ];
    }

    public static function fromArray(array $data): self
    {
        ValidationContext::pushPath('BracketsMatch');
        try {
            static::validateData($data);

            return new self(
                uuid: $data['match_id'],
                faceitUrl: (string) ($data['faceit_url'] ?? ''),
                round: (int) ($data['round'] ?? 0),
                position: (int) ($data['position'] ?? 0),
                state: (string) ($data['state'] ?? ''),
                results: isset($data['results']) ? MatchResult::fromArray($data['results']) : null,
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
