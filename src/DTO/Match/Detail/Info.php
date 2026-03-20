<?php

namespace Philicevic\FaceitPhp\DTO\Match\Detail;

use Philicevic\FaceitPhp\DTO\MatchResult;
use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
        ValidationContext::pushPath('DetailInfo');
        try {
            static::validateData($data);

            return new self(
                uuid: $data['match_id'],
                competitionId: $data['competition_id'],
                competitionName: $data['competition_name'],
                competitionType: $data['competition_type'],
                bestOf: (int) ($data['best_of'] ?? 1),
                status: $data['status'],
                game: $data['game'],
                region: $data['region'],
                organizerId: $data['organizer_id'],
                startedAt: isset($data['started_at']) ? new \DateTime('@'.$data['started_at']) : null,
                finishedAt: isset($data['finished_at']) ? new \DateTime('@'.$data['finished_at']) : null,
                scheduledAt: isset($data['scheduled_at']) ? new \DateTime('@'.$data['scheduled_at']) : null,
                faceitUrl: (string) ($data['faceit_url'] ?? ''),
                results: MatchResult::fromArray($data['results']),
                teams: array_map(Team::fromArray(...), array_values($data['teams'] ?? [])),
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
