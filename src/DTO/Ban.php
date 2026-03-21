<?php

namespace Philicevic\FaceitPhp\DTO;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class Ban
{
    use ValidatesFields;

    public function __construct(
        public string $userId,
        public string $nickname,
        public string $reason,
        public string $type,
        public string $game,
        public \DateTime $startsAt,
        public \DateTime $endsAt,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'user_id' => 'string',
            'nickname' => 'string',
            'reason' => 'string',
            'type' => 'string',
            'game' => '?string',
            'starts_at' => 'string',
            'ends_at' => 'string',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            userId: $d['user_id'],
            nickname: $d['nickname'],
            reason: $d['reason'],
            type: $d['type'],
            game: (string) ($d['game'] ?? ''),
            startsAt: new \DateTime($d['starts_at']),
            endsAt: new \DateTime($d['ends_at']),
        ));
    }
}
