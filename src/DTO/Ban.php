<?php

namespace Philicevic\FaceitPhp\DTO;

readonly class Ban
{
    public function __construct(
        public string $userId,
        public string $nickname,
        public string $reason,
        public string $type,
        public string $game,
        public \DateTime $startsAt,
        public \DateTime $endsAt,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            userId: $data['user_id'],
            nickname: $data['nickname'],
            reason: $data['reason'],
            type: $data['type'],
            game: (string) ($data['game'] ?? ''),
            startsAt: new \DateTime($data['starts_at']),
            endsAt: new \DateTime($data['ends_at']),
        );
    }
}
