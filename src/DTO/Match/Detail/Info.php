<?php

namespace Philicevic\FaceitPhp\DTO\Match\Detail;

use Philicevic\FaceitPhp\DTO\MatchResult;
use Philicevic\FaceitPhp\DTO\MatchScore;

class Info
{
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

    public static function fromArray(array $data): self
    {
        $results = isset($data['results']['winner'])
            ? new MatchResult(
                winner: $data['results']['winner'],
                score: new MatchScore(byFaction: $data['results']['score'] ?? []),
            )
            : new MatchResult(winner: '', score: new MatchScore(byFaction: []));

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
            results: $results,
            teams: array_map(
                fn (array $t): Team => Team::fromArray($t),
                array_values($data['teams'] ?? []),
            ),
        );
    }
}
