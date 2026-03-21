<?php

namespace Philicevic\FaceitPhp\DTO\Match\Detail;

use Philicevic\FaceitPhp\DTO\MatchResult;
use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class Info
{
    use ValidatesFields;

    /**
     * @param  array<Team>  $teams
     */
    public function __construct(
        public string $uuid,
        public string $competitionId,
        public string $competitionName,
        public string $competitionType,
        public int $bestOf,
        public string $status,
        public string $game,
        public string $region,
        public string $organizerId,
        public ?\DateTime $startedAt,
        public ?\DateTime $finishedAt,
        public ?\DateTime $scheduledAt,
        public string $faceitUrl,
        public MatchResult $results,
        public array $teams,
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'match_id' => 'string',
            'competition_id' => 'string',
            'competition_name' => 'string',
            'competition_type' => 'string',
            'best_of' => '?int',
            'status' => 'string',
            'game' => 'string',
            'region' => 'string',
            'organizer_id' => 'string',
            'started_at' => '?int',
            'finished_at' => '?int',
            'scheduled_at' => '?int',
            'faceit_url' => '?string',
            'results' => 'array',
            'teams' => '?array',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            uuid: $d['match_id'],
            competitionId: $d['competition_id'],
            competitionName: $d['competition_name'],
            competitionType: $d['competition_type'],
            bestOf: (int) ($d['best_of'] ?? 1),
            status: $d['status'],
            game: $d['game'],
            region: $d['region'],
            organizerId: $d['organizer_id'],
            startedAt: isset($d['started_at']) ? new \DateTime('@'.$d['started_at']) : null,
            finishedAt: isset($d['finished_at']) ? new \DateTime('@'.$d['finished_at']) : null,
            scheduledAt: isset($d['scheduled_at']) ? new \DateTime('@'.$d['scheduled_at']) : null,
            faceitUrl: (string) ($d['faceit_url'] ?? ''),
            results: MatchResult::fromArray($d['results']),
            teams: array_map(Team::fromArray(...), array_values($d['teams'] ?? [])),
        ));
    }
}
