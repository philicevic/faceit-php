<?php

namespace Philicevic\FaceitPhp\DTO\Championship;

use Philicevic\FaceitPhp\Enums\ChampionshipStatus;
use Philicevic\FaceitPhp\Enums\ChampionshipType;
use Philicevic\FaceitPhp\Enums\Region;
use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class Championship
{
    use ValidatesFields;

    /**
     * @param  ?array<mixed>  $joinChecks
     * @param  ?array<mixed>  $substitutionConfiguration
     * @param  ?array<mixed>  $schedule
     * @param  ?array<mixed>  $prizes
     * @param  ?array<mixed>  $stream
     */
    public function __construct(
        public string $uuid,
        public string $name,
        public string $gameId,
        public Region $region,
        public ChampionshipStatus $status,
        public ChampionshipType $type,
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
        public int $totalRounds,
        public int $totalPrizes,
        public string $rulesId,
        public string $seedingStrategy,
        public int $championshipStart,
        public int $checkinStart,
        public int $checkinClear,
        public bool $checkinEnabled,
        public int $subscriptionStart,
        public int $subscriptionEnd,
        public bool $subscriptionsLocked,
        public ?array $joinChecks,
        public ?array $substitutionConfiguration,
        public ?array $schedule,
        public ?array $prizes,
        public ?array $stream,
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
            'total_rounds' => '?int',
            'total_prizes' => '?int',
            'rules_id' => '?string',
            'seeding_strategy' => '?string',
            'championship_start' => '?int',
            'checkin_start' => '?int',
            'checkin_clear' => '?int',
            'checkin_enabled' => '?bool',
            'subscription_start' => '?int',
            'subscription_end' => '?int',
            'subscriptions_locked' => '?bool',
            'join_checks' => '?array',
            'substitution_configuration' => '?array',
            'schedule' => '?array',
            'prizes' => '?array',
            'stream' => '?array',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            uuid: $d['championship_id'],
            name: (string) ($d['name'] ?? ''),
            gameId: (string) ($d['game_id'] ?? ''),
            region: Region::from($d['region']),
            status: ChampionshipStatus::from($d['status']),
            type: ChampionshipType::from($d['type']),
            organizerId: (string) ($d['organizer_id'] ?? ''),
            faceitUrl: (string) ($d['faceit_url'] ?? ''),
            avatar: (string) ($d['avatar'] ?? ''),
            backgroundImage: (string) ($d['background_image'] ?? ''),
            coverImage: (string) ($d['cover_image'] ?? ''),
            description: (string) ($d['description'] ?? ''),
            anticheatRequired: (bool) ($d['anticheat_required'] ?? false),
            featured: (bool) ($d['featured'] ?? false),
            full: (bool) ($d['full'] ?? false),
            currentSubscriptions: (int) ($d['current_subscriptions'] ?? 0),
            slots: (int) ($d['slots'] ?? 0),
            totalGroups: (int) ($d['total_groups'] ?? 0),
            totalRounds: (int) ($d['total_rounds'] ?? 0),
            totalPrizes: (int) ($d['total_prizes'] ?? 0),
            rulesId: (string) ($d['rules_id'] ?? ''),
            seedingStrategy: (string) ($d['seeding_strategy'] ?? ''),
            championshipStart: (int) ($d['championship_start'] ?? 0),
            checkinStart: (int) ($d['checkin_start'] ?? 0),
            checkinClear: (int) ($d['checkin_clear'] ?? 0),
            checkinEnabled: (bool) ($d['checkin_enabled'] ?? false),
            subscriptionStart: (int) ($d['subscription_start'] ?? 0),
            subscriptionEnd: (int) ($d['subscription_end'] ?? 0),
            subscriptionsLocked: (bool) ($d['subscriptions_locked'] ?? false),
            joinChecks: $d['join_checks'] ?? null,
            substitutionConfiguration: $d['substitution_configuration'] ?? null,
            schedule: $d['schedule'] ?? null,
            prizes: $d['prizes'] ?? null,
            stream: $d['stream'] ?? null,
        ));
    }
}
