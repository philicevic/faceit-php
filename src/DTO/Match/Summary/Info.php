<?php

namespace Philicevic\FaceitPhp\DTO\Match\Summary;

use Philicevic\FaceitPhp\DTO\MatchResult;
use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

readonly class Info
{
    use ValidatesFields;

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

    protected static function fieldSchema(): array
    {
        return [
            'match_id' => 'string',
            'competition_id' => 'string',
            'competition_name' => 'string',
            'competition_type' => 'string',
            'status' => 'string',
            'game_id' => 'string',
            'game_mode' => 'string',
            'match_type' => 'string',
            'max_players' => 'int',
            'organizer_id' => 'string',
            'region' => 'string',
            'faceit_url' => 'string',
            'started_at' => 'int',
            'finished_at' => 'int',
            'results' => 'array',
            'teams' => '?array',
            'playing_players' => '?array',
        ];
    }

    public static function fromArray(array $data): self
    {
        ValidationContext::pushPath('SummaryInfo');
        try {
            static::validateData($data);

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
                teams: array_map(Team::fromArray(...), array_values($data['teams'] ?? [])),
                playingPlayers: $data['playing_players'] ?? [],
            );
        } finally {
            ValidationContext::popPath();
        }
    }
}
