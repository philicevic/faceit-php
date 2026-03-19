<?php

namespace Philicevic\FaceitPhp\DTO\Match\Summary;

use Philicevic\FaceitPhp\DTO\MatchResult;

readonly class Info
{
    /**
     * @param  array<Team>  $teams
     * @param  array<string>  $playingPlayers
     */
    public function __construct(
        public string $uuid,
        public string $competitionId,
        public string $competitionName,
        public string $competitionType,
        public string $status,
        public string $gameId,
        public string $gameMode,
        public string $matchType,
        public int $maxPlayers,
        public string $organizerId,
        public string $region,
        public string $faceitUrl,
        public \DateTime $startedAt,
        public \DateTime $finishedAt,
        public MatchResult $results,
        public array $teams,
        public array $playingPlayers,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['match_id'],
            competitionId: $data['competition_id'],
            competitionName: $data['competition_name'],
            competitionType: $data['competition_type'],
            status: $data['status'],
            gameId: $data['game_id'],
            gameMode: $data['game_mode'],
            matchType: $data['match_type'],
            maxPlayers: (int) $data['max_players'],
            organizerId: $data['organizer_id'],
            region: $data['region'],
            faceitUrl: $data['faceit_url'],
            startedAt: new \DateTime('@'.$data['started_at']),
            finishedAt: new \DateTime('@'.$data['finished_at']),
            results: MatchResult::fromArray($data['results']),
            teams: array_map(fn (array $t): Team => Team::fromArray($t), array_values($data['teams'] ?? [])),
            playingPlayers: $data['playing_players'] ?? [],
        );
    }
}
