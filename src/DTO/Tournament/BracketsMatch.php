<?php

namespace Philicevic\FaceitPhp\DTO\Tournament;

use Philicevic\FaceitPhp\DTO\MatchResult;
use Philicevic\FaceitPhp\Validation\ValidatesFields;

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
        return static::validated($data, fn ($d) => new self(
            uuid: $d['match_id'],
            faceitUrl: (string) ($d['faceit_url'] ?? ''),
            round: (int) ($d['round'] ?? 0),
            position: (int) ($d['position'] ?? 0),
            state: (string) ($d['state'] ?? ''),
            results: isset($d['results']) ? MatchResult::fromArray($d['results']) : null,
        ));
    }
}
