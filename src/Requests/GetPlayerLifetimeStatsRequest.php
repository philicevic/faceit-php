<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Player\LifetimeStats;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetPlayerLifetimeStatsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $playerId,
        protected readonly string $gameId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/players/'.$this->playerId.'/stats/'.$this->gameId;
    }

    public function createDtoFromResponse(Response $response): LifetimeStats
    {
        $data = $response->json();

        return new LifetimeStats(
            playerId: $data['player_id'],
            gameId: $data['game_id'],
            lifetime: $data['lifetime'] ?? [],
            segments: $data['segments'] ?? [],
        );
    }
}
