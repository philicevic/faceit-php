<?php

namespace Philicevic\FaceitPhp\DTO\Hub;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
        ValidationContext::pushPath('HubStatsPlayer');
        try {
            static::validateData($data);

            return new self(
                uuid: $data['player_id'],
                nickname: (string) ($data['nickname'] ?? ''),
                stats: $data['stats'] ?? [],
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
