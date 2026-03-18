<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Player\Hub;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetPlayerHubsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $playerId,
        protected readonly int $offset = 0,
        protected readonly int $limit = 50,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/players/'.$this->playerId.'/hubs';
    }

    protected function defaultQuery(): array
    {
        return [
            'offset' => $this->offset,
            'limit' => $this->limit,
        ];
    }

    /**
     * @return PaginatedResponse<Hub>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        $data = $response->json();
        $items = array_map(function (array $hub): Hub {
            return new Hub(
                uuid: $hub['hub_id'],
                name: $hub['name'],
                avatar: (string) ($hub['avatar'] ?? ''),
                coverImage: (string) ($hub['cover_image'] ?? ''),
                backgroundImage: (string) ($hub['background_image'] ?? ''),
                faceitUrl: (string) ($hub['faceit_url'] ?? ''),
                description: (string) ($hub['description'] ?? ''),
                gameId: (string) ($hub['game_id'] ?? ''),
                region: (string) ($hub['region'] ?? ''),
            );
        }, $data['items'] ?? []);

        return new PaginatedResponse(
            items: $items,
            start: $data['start'] ?? 0,
            end: $data['end'] ?? 0,
        );
    }
}
