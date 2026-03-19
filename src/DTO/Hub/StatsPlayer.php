<?php

namespace Philicevic\FaceitPhp\DTO\Hub;

class StatsPlayer
{
    /**
     * @param  array<string, mixed>  $stats
     */
    public function __construct(
        public readonly string $uuid,
        public readonly string $nickname,
        public readonly array $stats,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['player_id'],
            nickname: (string) ($data['nickname'] ?? ''),
            stats: $data['stats'] ?? [],
        );
    }
}
