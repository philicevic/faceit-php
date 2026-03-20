<?php

namespace Philicevic\FaceitPhp\DTO\Match\Stats;

readonly class Player
{
    /**
     * @param  array<string, mixed>  $stats
     */
    public function __construct(
        public string $uuid,
        public string $nickname,
        public array $stats,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['player_id'],
            nickname: $data['nickname'],
            stats: $data['player_stats'],
        );
    }
}
