<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Player\StatsPlayer;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetHubStatsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $hubId,
        protected readonly int $offset = 0,
        protected readonly int $limit = 20,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/hubs/'.$this->hubId.'/stats';
    }

    protected function defaultQuery(): array
    {
        return [
            'offset' => $this->offset,
            'limit' => $this->limit,
        ];
    }

    /**
     * @return PaginatedResponse<StatsPlayer>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        $data = $response->json();

        return new PaginatedResponse(
            items: array_map(fn (array $p): StatsPlayer => StatsPlayer::fromArray($p), $data['players'] ?? []),
            start: $data['start'] ?? 0,
            end: $data['end'] ?? 0,
        );
    }
}
