<?php

namespace Philicevic\FaceitPhp\DTO\Match\Stats;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

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
        return static::validated($data, fn ($d) => new self(
            uuid: $d['player_id'],
            nickname: $d['nickname'],
            stats: $d['player_stats'],
        ));
    }
}
