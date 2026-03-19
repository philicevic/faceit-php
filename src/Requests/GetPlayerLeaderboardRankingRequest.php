<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Leaderboard\Ranking;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetPlayerLeaderboardRankingRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $leaderboardId,
        protected readonly string $playerId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/leaderboards/'.$this->leaderboardId.'/players/'.$this->playerId;
    }

    public function createDtoFromResponse(Response $response): Ranking
    {
        return Ranking::fromArray($response->json());
    }
}
