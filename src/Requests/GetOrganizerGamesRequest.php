<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Game\Game;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetOrganizerGamesRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $organizerId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/organizers/'.$this->organizerId.'/games';
    }

    /**
     * @return PaginatedResponse<Game>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        $data = $response->json();

        $items = array_map(fn (array $g): Game => Game::fromArray($g), $data['items'] ?? []);

        return new PaginatedResponse(
            items: $items,
            start: $data['start'] ?? 0,
            end: $data['end'] ?? 0,
        );
    }
}
