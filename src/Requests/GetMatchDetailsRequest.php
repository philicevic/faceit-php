<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Match\Detail\Info;
use Philicevic\FaceitPhp\DTO\Match\Detail\Player;
use Philicevic\FaceitPhp\DTO\Match\Detail\Team;
use Philicevic\FaceitPhp\DTO\MatchResult;
use Philicevic\FaceitPhp\DTO\MatchScore;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetMatchDetailsRequest extends Request
{
    public function __construct(protected readonly string $uuid) {}

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/matches/'.$this->uuid;
    }

    public function createDtoFromResponse(Response $response): Info
    {
        $data = $response->json();

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
        }, array_values($data['teams'] ?? []));

        $results = new MatchResult(
            winner: $data['results']['winner'],
            score: new MatchScore(byFaction: $data['results']['score']),
        );

        return new Info(
            uuid: $data['match_id'],
            competitionId: $data['competition_id'],
            competitionName: $data['competition_name'],
            competitionType: $data['competition_type'],
            bestOf: (int) $data['best_of'],
            status: $data['status'],
            game: $data['game'],
            region: $data['region'],
            organizerId: $data['organizer_id'],
            startedAt: isset($data['started_at']) ? new \DateTime('@'.$data['started_at']) : null,
            finishedAt: isset($data['finished_at']) ? new \DateTime('@'.$data['finished_at']) : null,
            scheduledAt: isset($data['scheduled_at']) ? new \DateTime('@'.$data['scheduled_at']) : null,
            faceitUrl: (string) ($data['faceit_url'] ?? ''),
            results: $results,
            teams: $teams,
        );
    }
}
