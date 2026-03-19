<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\League\PlayerInLeague;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetLeagueSeasonPlayerRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $leagueId,
        protected readonly string $seasonId,
        protected readonly string $playerId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/leagues/'.$this->leagueId.'/seasons/'.$this->seasonId.'/players/'.$this->playerId;
    }

    public function createDtoFromResponse(Response $response): PlayerInLeague
    {
        return PlayerInLeague::fromArray($response->json());
    }
}
