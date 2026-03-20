<?php

namespace Philicevic\FaceitPhp\DTO\Leaderboard;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
        ValidationContext::pushPath('EntityRanking');
        try {
            static::validateData($data);

            return new self(
                leaderboard: Leaderboard::fromArray($data['leaderboard']),
                items: array_map(RankingItem::fromArray(...), $data['items'] ?? []),
                start: $data['start'] ?? 0,
                end: $data['end'] ?? 0,
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
