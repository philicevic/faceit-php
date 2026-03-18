<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Tournament\Team;
use Philicevic\FaceitPhp\DTO\Tournament\Teams;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetTournamentTeamsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $tournamentId,
        protected readonly int $offset = 0,
        protected readonly int $limit = 20,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/tournaments/'.$this->tournamentId.'/teams';
    }

    protected function defaultQuery(): array
    {
        return [
            'offset' => $this->offset,
            'limit' => $this->limit,
        ];
    }

    public function createDtoFromResponse(Response $response): Teams
    {
        $data = $response->json();

        $hydrate = function (array $teams): array {
            return array_map(function (array $team): Team {
                return new Team(
                    uuid: $team['team_id'],
                    nickname: (string) ($team['nickname'] ?? ''),
                    teamLeader: (string) ($team['team_leader'] ?? ''),
                    teamType: (string) ($team['team_type'] ?? ''),
                    skillLevel: (int) ($team['skill_level'] ?? 0),
                    subsDone: (int) ($team['subs_done'] ?? 0),
                );
            }, $teams);
        };

        return new Teams(
            checkedIn: $hydrate($data['checked_in'] ?? []),
            finished: $hydrate($data['finished'] ?? []),
            joined: $hydrate($data['joined'] ?? []),
            started: $hydrate($data['started'] ?? []),
        );
    }
}
