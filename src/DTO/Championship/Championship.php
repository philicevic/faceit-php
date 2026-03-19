<?php

namespace Philicevic\FaceitPhp\DTO\Championship;

readonly class Championship
{
    public function __construct(
        public string $uuid,
        public string $name,
        public string $gameId,
        public string $region,
        public string $status,
        public string $type,
        public string $avatar,
        public string $backgroundImage,
        public string $coverImage,
        public string $description,
        public string $faceitUrl,
        public string $organizerId,
        public string $seedingStrategy,
        public int $slots,
        public int $currentSubscriptions,
        public int $totalGroups,
        public int $totalPrizes,
        public int $totalRounds,
        public int $championshipStart,
        public int $checkinStart,
        public int $checkinClear,
        public int $subscriptionStart,
        public int $subscriptionEnd,
        public bool $anticheatRequired,
        public bool $checkinEnabled,
        public bool $featured,
        public bool $full,
        public bool $subscriptionsLocked,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['championship_id'],
            name: (string) ($data['name'] ?? ''),
            gameId: (string) ($data['game_id'] ?? ''),
            region: (string) ($data['region'] ?? ''),
            status: (string) ($data['status'] ?? ''),
            type: (string) ($data['type'] ?? ''),
            avatar: (string) ($data['avatar'] ?? ''),
            backgroundImage: (string) ($data['background_image'] ?? ''),
            coverImage: (string) ($data['cover_image'] ?? ''),
            description: (string) ($data['description'] ?? ''),
            faceitUrl: (string) ($data['faceit_url'] ?? ''),
            organizerId: (string) ($data['organizer_id'] ?? ''),
            seedingStrategy: (string) ($data['seeding_strategy'] ?? ''),
            slots: (int) ($data['slots'] ?? 0),
            currentSubscriptions: (int) ($data['current_subscriptions'] ?? 0),
            totalGroups: (int) ($data['total_groups'] ?? 0),
            totalPrizes: (int) ($data['total_prizes'] ?? 0),
            totalRounds: (int) ($data['total_rounds'] ?? 0),
            championshipStart: (int) ($data['championship_start'] ?? 0),
            checkinStart: (int) ($data['checkin_start'] ?? 0),
            checkinClear: (int) ($data['checkin_clear'] ?? 0),
            subscriptionStart: (int) ($data['subscription_start'] ?? 0),
            subscriptionEnd: (int) ($data['subscription_end'] ?? 0),
            anticheatRequired: (bool) ($data['anticheat_required'] ?? false),
            checkinEnabled: (bool) ($data['checkin_enabled'] ?? false),
            featured: (bool) ($data['featured'] ?? false),
            full: (bool) ($data['full'] ?? false),
            subscriptionsLocked: (bool) ($data['subscriptions_locked'] ?? false),
        );
    }
}
