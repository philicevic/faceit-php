<?php

namespace Philicevic\FaceitPhp\DTO\Leaderboard;

readonly class EntityRanking
{
    /**
     * @param  array<RankingItem>  $items
     */
    public function __construct(
        public Leaderboard $leaderboard,
        public array $items,
        public int $start,
        public int $end,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            leaderboard: Leaderboard::fromArray($data['leaderboard']),
            items: array_map(RankingItem::fromArray(...), $data['items'] ?? []),
            start: $data['start'] ?? 0,
            end: $data['end'] ?? 0,
        );
    }
}
