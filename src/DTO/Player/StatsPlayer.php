<?php

namespace Philicevic\FaceitPhp\DTO\Player;

readonly class StatsPlayer
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
            uuid: (string) ($data['player_id'] ?? ''),
            nickname: (string) ($data['nickname'] ?? ''),
            stats: $data['player_stats'] ?? $data['stats'] ?? [],
        );
    }
}
