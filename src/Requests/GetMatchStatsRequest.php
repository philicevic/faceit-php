<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Match\Stats\MatchStats;
use Philicevic\FaceitPhp\DTO\Match\Stats\Player;
use Philicevic\FaceitPhp\DTO\Match\Stats\Round;
use Philicevic\FaceitPhp\DTO\Match\Stats\Team;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetMatchStatsRequest extends Request
{
    public function __construct(protected readonly string $uuid) {}

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/matches/'.$this->uuid.'/stats';
    }

    public function createDtoFromResponse(Response $response): MatchStats
    {
        $data = $response->json();

        $rounds = array_map(function ($item) {
            $teams = array_map(function ($team) {
                return new Team(
                    uuid: $team['team_id'],
                    premade: (bool) $team['premade'],
                    stats: $team['team_stats'],
                    players: array_map(function ($player) {
                        return new Player(
                            uuid: $player['player_id'],
                            nickname: $player['nickname'],
                            stats: $player['player_stats'],
                        );
                    }, $team['players']),
                );
            }, $item['teams']);

            return new Round(
                bestOf: (int) $item['best_of'],
                competitionId: $item['competition_id'],
                gameId: $item['game_id'],
                gameMode: $item['game_mode'],
                matchId: $item['match_id'],
                matchRound: (int) $item['match_round'],
                played: $item['played'] == '1',
                stats: $item['round_stats'],
                teams: $teams,
            );
        }, $data['rounds']);

        return new MatchStats(
            rounds: $rounds,
        );
    }
}
