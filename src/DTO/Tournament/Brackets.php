<?php

namespace Philicevic\FaceitPhp\DTO\Tournament;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class Brackets
{
    use ValidatesFields;

    /**
     * @param  array<BracketsMatch>  $matches
     * @param  array<BracketsRound>  $rounds
     */
    public function __construct(
        public string $game,
        public string $name,
        public string $status,
        public array $matches,
        public array $rounds,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'game' => '?string',
            'name' => '?string',
            'status' => '?string',
            'matches' => '?array',
            'rounds' => '?array',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            game: (string) ($d['game'] ?? ''),
            name: (string) ($d['name'] ?? ''),
            status: (string) ($d['status'] ?? ''),
            matches: array_map(BracketsMatch::fromArray(...), $d['matches'] ?? []),
            rounds: array_map(BracketsRound::fromArray(...), $d['rounds'] ?? []),
        ));
    }
}
