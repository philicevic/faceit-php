<?php

namespace Philicevic\FaceitPhp\DTO\Leaderboard;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class EntityRanking
{
    use ValidatesFields;

    /**
     * @param  array<RankingItem>  $items
     */
    public function __construct(
        public Leaderboard $leaderboard,
        public array $items,
        public int $start,
        public int $end,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'leaderboard' => 'array',
            'items' => '?array',
            'start' => '?int',
            'end' => '?int',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            leaderboard: Leaderboard::fromArray($d['leaderboard']),
            items: array_map(RankingItem::fromArray(...), $d['items'] ?? []),
            start: $d['start'] ?? 0,
            end: $d['end'] ?? 0,
        ));
    }
}
