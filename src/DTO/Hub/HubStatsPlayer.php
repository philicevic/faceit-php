<?php

namespace Philicevic\FaceitPhp\DTO\Hub;

readonly class HubStatsPlayer
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
            nickname: (string) ($data['nickname'] ?? ''),
            stats: $data['stats'] ?? [],
        );
    }
}
