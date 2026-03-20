<?php

namespace Philicevic\FaceitPhp\DTO\Tournament;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
        ValidationContext::pushPath('Brackets');
        try {
            static::validateData($data);

            return new self(
                game: (string) ($data['game'] ?? ''),
                name: (string) ($data['name'] ?? ''),
                status: (string) ($data['status'] ?? ''),
                matches: array_map(BracketsMatch::fromArray(...), $data['matches'] ?? []),
                rounds: array_map(BracketsRound::fromArray(...), $data['rounds'] ?? []),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
