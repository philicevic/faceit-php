<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Match\Summary\Info;
use Philicevic\FaceitPhp\DTO\Match\Summary\Player;
use Philicevic\FaceitPhp\DTO\Match\Summary\Team;
use Philicevic\FaceitPhp\DTO\MatchResult;
use Philicevic\FaceitPhp\DTO\MatchScore;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetPlayerMatchesRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $playerId,
        protected readonly string $game,
        protected readonly ?int $from = null,
        protected readonly ?int $to = null,
        protected readonly int $offset = 0,
        protected readonly int $limit = 20,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/players/'.$this->playerId.'/history';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'game' => $this->game,
            'from' => $this->from,
            'to' => $this->to,
            'offset' => $this->offset,
            'limit' => $this->limit,
        ], static fn (mixed $value): bool => $value !== null);
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
                        faceitUrl: (string) ($player['faceit_url'] ?? ''),
                        gamePlayerId: (string) ($player['game_player_id'] ?? ''),
                        gamePlayerName: (string) ($player['game_player_name'] ?? ''),
                    );
                }, $team['players'] ?? []);

                return new Team(
                    uuid: (string) ($team['team_id'] ?? $team['nickname']),
                    nickname: (string) ($team['nickname'] ?? ''),
                    avatar: (string) ($team['avatar'] ?? ''),
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
                status: $match['status'],
                gameId: $match['game_id'],
                gameMode: $match['game_mode'],
                matchType: $match['match_type'],
                maxPlayers: (int) $match['max_players'],
                organizerId: $match['organizer_id'],
                region: $match['region'],
                faceitUrl: $match['faceit_url'],
                startedAt: new \DateTime('@'.$match['started_at']),
                finishedAt: new \DateTime('@'.$match['finished_at']),
                results: $results,
                teams: $teams,
                playingPlayers: $match['playing_players'] ?? [],
            );
        }, $data['items'] ?? []);

        return new PaginatedResponse(
            items: $items,
            start: $data['start'] ?? 0,
            end: $data['end'] ?? 0,
            from: $data['from'] ?? 0,
            to: $data['to'] ?? 0,
        );
    }
}
