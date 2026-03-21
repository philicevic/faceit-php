<?php

namespace Philicevic\FaceitPhp\DTO\Hub;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class HubStatsPlayer
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
            'nickname' => '?string',
            'stats' => '?array',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            uuid: $d['player_id'],
            nickname: (string) ($d['nickname'] ?? ''),
            stats: $d['stats'] ?? [],
        ));
    }
}
