<?php

namespace Philicevic\FaceitPhp\DTO\Match\Detail;

use Philicevic\FaceitPhp\DTO\MatchResult;
use Philicevic\FaceitPhp\Enums\CompetitionType;
use Philicevic\FaceitPhp\Enums\MatchStatus;
use Philicevic\FaceitPhp\Enums\Region;
use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class Info
{
    use ValidatesFields;

    /**
     * @param  array<Team>  $teams
     * @param  array<string>  $demoUrl
     * @param  ?array<mixed>  $voting
     * @param  ?array<mixed>  $detailedResults
     * @param  ?array<mixed>  $instances
     */
    public function __construct(
        public string $uuid,
        public string $competitionId,
        public string $competitionName,
        public CompetitionType $competitionType,
        public int $bestOf,
        public MatchStatus $status,
        public string $game,
        public Region $region,
        public string $organizerId,
        public ?\DateTime $startedAt,
        public ?\DateTime $finishedAt,
        public ?\DateTime $scheduledAt,
        public ?\DateTime $configuredAt,
        public string $faceitUrl,
        public string $chatRoomId,
        public int $version,
        public bool $calculateElo,
        public array $demoUrl,
        public ?MatchResult $results,
        public ?array $voting,
        public ?array $detailedResults,
        public ?array $instances,
        public array $teams,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'match_id' => 'string',
            'competition_id' => 'string',
            'competition_name' => 'string',
            'competition_type' => CompetitionType::class,
            'best_of' => '?int',
            'status' => MatchStatus::class,
            'game' => 'string',
            'region' => Region::class,
            'organizer_id' => 'string',
            'started_at' => '?int',
            'finished_at' => '?int',
            'scheduled_at' => '?int',
            'configured_at' => '?int',
            'faceit_url' => '?string',
            'chat_room_id' => '?string',
            'version' => '?int',
            'calculate_elo' => '?bool',
            'demo_url' => '?array',
            'results' => '?'.MatchResult::class,
            'voting' => '?array',
            'detailed_results' => '?array',
            'instances' => '?array',
            'teams' => '?array',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            uuid: $d['match_id'],
            competitionId: $d['competition_id'],
            competitionName: $d['competition_name'],
            competitionType: CompetitionType::from($d['competition_type']),
            bestOf: (int) ($d['best_of'] ?? 1),
            status: MatchStatus::from($d['status']),
            game: $d['game'],
            region: Region::from($d['region']),
            organizerId: $d['organizer_id'],
            startedAt: isset($d['started_at']) ? new \DateTime('@'.$d['started_at']) : null,
            finishedAt: isset($d['finished_at']) ? new \DateTime('@'.$d['finished_at']) : null,
            scheduledAt: isset($d['scheduled_at']) ? new \DateTime('@'.$d['scheduled_at']) : null,
            configuredAt: isset($d['configured_at']) ? new \DateTime('@'.$d['configured_at']) : null,
            faceitUrl: (string) ($d['faceit_url'] ?? ''),
            chatRoomId: (string) ($d['chat_room_id'] ?? ''),
            version: (int) ($d['version'] ?? 0),
            calculateElo: (bool) ($d['calculate_elo'] ?? false),
            demoUrl: $d['demo_url'] ?? [],
            results: isset($d['results']) ? MatchResult::fromArray($d['results']) : null,
            voting: $d['voting'] ?? null,
            detailedResults: $d['detailed_results'] ?? null,
            instances: $d['instances'] ?? null,
            teams: array_map(Team::fromArray(...), array_values($d['teams'] ?? [])),
        ));
    }
}
