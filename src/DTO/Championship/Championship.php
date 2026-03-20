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
        public string $organizerId,
        public string $faceitUrl,
        public string $avatar,
        public string $backgroundImage,
        public string $coverImage,
        public string $description,
        public bool $anticheatRequired,
        public bool $featured,
        public bool $full,
        public int $currentSubscriptions,
        public int $slots,
        public int $totalGroups,
        public string $rulesId,
        public string $seedingStrategy,
        public int $championshipStart,
        public int $checkinStart,
        public int $checkinClear,
        public bool $checkinEnabled,
        public int $subscriptionStart,
        public int $subscriptionEnd,
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
            organizerId: (string) ($data['organizer_id'] ?? ''),
            faceitUrl: (string) ($data['faceit_url'] ?? ''),
            avatar: (string) ($data['avatar'] ?? ''),
            backgroundImage: (string) ($data['background_image'] ?? ''),
            coverImage: (string) ($data['cover_image'] ?? ''),
            description: (string) ($data['description'] ?? ''),
            anticheatRequired: (bool) ($data['anticheat_required'] ?? false),
            featured: (bool) ($data['featured'] ?? false),
            full: (bool) ($data['full'] ?? false),
            currentSubscriptions: (int) ($data['current_subscriptions'] ?? 0),
            slots: (int) ($data['slots'] ?? 0),
            totalGroups: (int) ($data['total_groups'] ?? 0),
            rulesId: (string) ($data['rules_id'] ?? ''),
            seedingStrategy: (string) ($data['seeding_strategy'] ?? ''),
            championshipStart: (int) ($data['championship_start'] ?? 0),
            checkinStart: (int) ($data['checkin_start'] ?? 0),
            checkinClear: (int) ($data['checkin_clear'] ?? 0),
            checkinEnabled: (bool) ($data['checkin_enabled'] ?? false),
            subscriptionStart: (int) ($data['subscription_start'] ?? 0),
            subscriptionEnd: (int) ($data['subscription_end'] ?? 0),
            subscriptionsLocked: (bool) ($data['subscriptions_locked'] ?? false),
        );
    }
}
