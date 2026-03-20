<?php

namespace Philicevic\FaceitPhp\DTO\Championship;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

readonly class Championship
{
    use ValidatesFields;

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

    protected static function fieldSchema(): array
    {
        return [
            'championship_id' => 'string',
            'name' => '?string',
            'game_id' => '?string',
            'region' => '?string',
            'status' => '?string',
            'type' => '?string',
            'organizer_id' => '?string',
            'faceit_url' => '?string',
            'avatar' => '?string',
            'background_image' => '?string',
            'cover_image' => '?string',
            'description' => '?string',
            'anticheat_required' => '?bool',
            'featured' => '?bool',
            'full' => '?bool',
            'current_subscriptions' => '?int',
            'slots' => '?int',
            'total_groups' => '?int',
            'rules_id' => '?string',
            'seeding_strategy' => '?string',
            'championship_start' => '?int',
            'checkin_start' => '?int',
            'checkin_clear' => '?int',
            'checkin_enabled' => '?bool',
            'subscription_start' => '?int',
            'subscription_end' => '?int',
            'subscriptions_locked' => '?bool',
        ];
    }

    public static function fromArray(array $data): self
    {
        ValidationContext::pushPath('Championship');
        try {
            static::validateData($data);

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
        } finally {
            ValidationContext::popPath();
        }
    }
}
