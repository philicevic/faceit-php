<?php

namespace Philicevic\FaceitPhp\DTO\Match\Stats;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

readonly class Player
{
    use ValidatesFields;

    /**
     * @param  array<string, mixed>  $stats
     */
    public function __construct(
        public string $uuid,
        public string $nickname,
        public array $stats,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'player_id' => 'string',
            'nickname' => 'string',
            'player_stats' => 'array',
        ];
    }

    public static function fromArray(array $data): self
    {
        ValidationContext::pushPath('StatsPlayer');
        try {
            static::validateData($data);

            return new self(
                uuid: $data['player_id'],
                nickname: $data['nickname'],
                stats: $data['player_stats'],
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
