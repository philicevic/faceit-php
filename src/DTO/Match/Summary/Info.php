<?php

namespace Philicevic\FaceitPhp\DTO\Match\Summary;

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
     * @param  array<string>  $playingPlayers
     */
    public function __construct(
        public string $uuid,
        public string $competitionId,
        public string $competitionName,
        public CompetitionType $competitionType,
        public MatchStatus $status,
        public string $gameId,
        public string $gameMode,
        public string $matchType,
        public int $maxPlayers,
        public string $organizerId,
        public Region $region,
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
        return static::validated($data, fn ($d) => new self(
            uuid: $d['match_id'],
            competitionId: $d['competition_id'],
            competitionName: $d['competition_name'],
            competitionType: CompetitionType::from($d['competition_type']),
            status: MatchStatus::from(strtoupper($d['status'])),
            gameId: $d['game_id'],
            gameMode: $d['game_mode'],
            matchType: $d['match_type'],
            maxPlayers: (int) $d['max_players'],
            organizerId: $d['organizer_id'],
            region: Region::from($d['region']),
            faceitUrl: $d['faceit_url'],
            startedAt: new \DateTime('@'.$d['started_at']),
            finishedAt: new \DateTime('@'.$d['finished_at']),
            results: MatchResult::fromArray($d['results']),
            teams: array_map(Team::fromArray(...), array_values($d['teams'] ?? [])),
            playingPlayers: $d['playing_players'] ?? [],
        ));
    }
}
