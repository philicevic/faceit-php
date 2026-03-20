<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Player;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetPlayerLookupRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly ?string $nickname = null,
        protected readonly ?string $game = null,
        protected readonly ?string $gamePlayerId = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/players';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'nickname' => $this->nickname,
            'game' => $this->game,
            'game_player_id' => $this->gamePlayerId,
        ], static fn (mixed $value): bool => $value !== null);
    }

    public function createDtoFromResponse(Response $response): Player
    {
        return Player::fromArray($response->json());
    }
}
