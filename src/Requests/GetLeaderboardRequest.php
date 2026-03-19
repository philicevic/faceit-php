<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\Leaderboard\EntityRanking;
use Philicevic\FaceitPhp\DTO\Leaderboard\Leaderboard;
use Philicevic\FaceitPhp\DTO\Leaderboard\Ranking;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetLeaderboardRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $leaderboardId,
        protected readonly int $offset = 0,
        protected readonly int $limit = 20,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/leaderboards/'.$this->leaderboardId;
    }

    protected function defaultQuery(): array
    {
        return [
            'offset' => $this->offset,
            'limit' => $this->limit,
        ];
    }

    public function createDtoFromResponse(Response $response): EntityRanking
    {
        $data = $response->json();

        $items = array_map(fn (array $r): Ranking => Ranking::fromArray($r), $data['items'] ?? []);

        return new EntityRanking(
            start: $data['start'] ?? 0,
            end: $data['end'] ?? 0,
            leaderboard: Leaderboard::fromArray($data['leaderboard'] ?? []),
            items: $items,
        );
    }
}
