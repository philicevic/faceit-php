<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Match\Detail\Info;
use Philicevic\FaceitPhp\DTO\Match\Detail\Player;
use Philicevic\FaceitPhp\DTO\Match\Detail\Team;
use Philicevic\FaceitPhp\DTO\MatchResult;
use Philicevic\FaceitPhp\DTO\MatchScore;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetTournamentMatchesRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $tournamentId,
        protected readonly int $offset = 0,
        protected readonly int $limit = 20,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/tournaments/'.$this->tournamentId.'/matches';
    }

    protected function defaultQuery(): array
    {
        return [
            'offset' => $this->offset,
            'limit' => $this->limit,
        ];
    }

    /**
     * @return PaginatedResponse<Info>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        $data = $response->json();
        $items = array_map(function (array $match): Info {
            $teams = array_map(function (array $team): Team {
                $players = array_map(function (array $player): Player {
                    return new Player(
                        uuid: $player['player_id'],
                        nickname: $player['nickname'],
                        avatar: (string) ($player['avatar'] ?? ''),
                        membership: (string) ($player['membership'] ?? ''),
                        gamePlayerId: (string) ($player['game_player_id'] ?? ''),
                        gamePlayerName: (string) ($player['game_player_name'] ?? ''),
                        gameSkillLevel: (int) ($player['game_skill_level'] ?? 0),
                        anticheatRequired: (bool) ($player['anticheat_required'] ?? false),
                    );
                }, $team['roster'] ?? []);

                return new Team(
                    uuid: $team['faction_id'],
                    name: (string) ($team['name'] ?? ''),
                    avatar: (string) ($team['avatar'] ?? ''),
                    leader: (string) ($team['leader'] ?? ''),
                    type: (string) ($team['type'] ?? ''),
                    players: $players,
                );
            }, array_values($match['teams'] ?? []));

            $results = new MatchResult(
                winner: $match['results']['winner'],
                score: new MatchScore(byFaction: $match['results']['score']),
            );

            return new Info(
                uuid: $match['match_id'],
                competitionId: $match['competition_id'],
                competitionName: $match['competition_name'],
                competitionType: $match['competition_type'],
                bestOf: (int) ($match['best_of'] ?? 1),
                status: $match['status'],
                game: $match['game'],
                region: $match['region'],
                organizerId: $match['organizer_id'],
                startedAt: isset($match['started_at']) ? new \DateTime('@'.$match['started_at']) : null,
                finishedAt: isset($match['finished_at']) ? new \DateTime('@'.$match['finished_at']) : null,
                scheduledAt: isset($match['scheduled_at']) ? new \DateTime('@'.$match['scheduled_at']) : null,
                faceitUrl: (string) ($match['faceit_url'] ?? ''),
                results: $results,
                teams: $teams,
            );
        }, $data['items'] ?? []);

        return new PaginatedResponse(
            items: $items,
            start: $data['start'] ?? 0,
            end: $data['end'] ?? 0,
        );
    }
}
