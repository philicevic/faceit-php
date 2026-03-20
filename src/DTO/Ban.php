<?php

namespace Philicevic\FaceitPhp\DTO;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
        ValidationContext::pushPath('Ban');
        try {
            static::validateData($data);

            return new self(
                userId: $data['user_id'],
                nickname: $data['nickname'],
                reason: $data['reason'],
                type: $data['type'],
                game: (string) ($data['game'] ?? ''),
                startsAt: new \DateTime($data['starts_at']),
                endsAt: new \DateTime($data['ends_at']),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
