<?php

namespace Philicevic\FaceitPhp\DTO\Championship;

class Championship
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $name,
        public readonly string $gameId,
        public readonly string $region,
        public readonly string $status,
        public readonly string $type,
        public readonly string $avatar,
        public readonly string $backgroundImage,
        public readonly string $coverImage,
        public readonly string $description,
        public readonly string $faceitUrl,
        public readonly string $organizerId,
        public readonly string $seedingStrategy,
        public readonly int $slots,
        public readonly int $currentSubscriptions,
        public readonly int $totalGroups,
        public readonly int $totalPrizes,
        public readonly int $totalRounds,
        public readonly int $championshipStart,
        public readonly int $checkinStart,
        public readonly int $checkinClear,
        public readonly int $subscriptionStart,
        public readonly int $subscriptionEnd,
        public readonly bool $anticheatRequired,
        public readonly bool $checkinEnabled,
        public readonly bool $featured,
        public readonly bool $full,
        public readonly bool $subscriptionsLocked,
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
