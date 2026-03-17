<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Player;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetPlayerRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $uuid
    ) {}

    public function resolveEndpoint(): string
    {
        return '/players/'.$this->uuid;
    }

    public function createDtoFromResponse(Response $response): Player
    {
        $data = $response->json();

        return new Player(
            uuid: $data['player_id'],
            nickname: $data['nickname'],
            avatar: $data['avatar'],
            country: $data['country'],
            coverImage: $data['cover_image'],
            activatedAt: new \DateTime($data['activated_at']),
        );
    }
}
