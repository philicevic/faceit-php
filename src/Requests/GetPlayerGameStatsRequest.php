<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Player\GameMatchStats;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetPlayerGameStatsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $playerId,
        protected readonly string $gameId,
        protected readonly int $offset = 0,
        protected readonly int $limit = 20,
        protected readonly ?int $from = null,
        protected readonly ?int $to = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/players/'.$this->playerId.'/games/'.$this->gameId.'/stats';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'offset' => $this->offset,
            'limit' => $this->limit,
            'from' => $this->from,
            'to' => $this->to,
        ], static fn (mixed $value): bool => $value !== null);
    }

    /**
     * @return PaginatedResponse<GameMatchStats>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        $data = $response->json();
        $items = array_map(function (array $item): GameMatchStats {
            return new GameMatchStats(stats: $item['stats'] ?? []);
        }, $data['items'] ?? []);

        return new PaginatedResponse(
            items: $items,
            start: $data['start'] ?? 0,
            end: $data['end'] ?? 0,
        );
    }
}
