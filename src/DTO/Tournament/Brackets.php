<?php

namespace Philicevic\FaceitPhp\DTO\Tournament;

readonly class Brackets
{
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

    public static function fromArray(array $data): self
    {
        return new self(
            game: (string) ($data['game'] ?? ''),
            name: (string) ($data['name'] ?? ''),
            status: (string) ($data['status'] ?? ''),
            matches: array_map(BracketsMatch::fromArray(...), $data['matches'] ?? []),
            rounds: array_map(BracketsRound::fromArray(...), $data['rounds'] ?? []),
        );
    }
}
