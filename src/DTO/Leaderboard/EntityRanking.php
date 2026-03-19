<?php

namespace Philicevic\FaceitPhp\DTO\Leaderboard;

readonly class EntityRanking
{
    /**
     * @param  array<Ranking>  $items
     */
    public function __construct(
        public int $start,
        public int $end,
        public Leaderboard $leaderboard,
        public array $items,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            start: (int) ($data['start'] ?? 0),
            end: (int) ($data['end'] ?? 0),
            leaderboard: Leaderboard::fromArray($data['leaderboard'] ?? []),
            items: array_map(fn (array $r): Ranking => Ranking::fromArray($r), $data['items'] ?? []),
        );
    }
}
