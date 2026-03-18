<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Search\Game;
use Philicevic\FaceitPhp\DTO\Search\Player;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class SearchPlayersRequest extends Request
{
    protected Method $method = Method::GET;

    protected const ALLOWED_FILTERS = ['game', 'country'];

    public function __construct(
        protected readonly string $searchQuery,
        protected readonly int $offset = 0,
        protected readonly int $limit = 20,
        protected readonly array $filters = [],
    ) {
        $invalid = array_diff(array_keys($filters), self::ALLOWED_FILTERS);
        if ($invalid) {
            throw new \InvalidArgumentException(
                'Invalid filters for player search: '.implode(', ', $invalid)
            );
        }
    }

    public function resolveEndpoint(): string
    {
        return '/search/players';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'nickname' => $this->searchQuery,
            'offset' => $this->offset,
            'limit' => $this->limit,
            'game' => $this->filters['game'] ?? null,
            'country' => $this->filters['country'] ?? null,
        ], static fn (mixed $value): bool => $value !== null);
    }

    /**
     * @return PaginatedResponse<Player>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        $data = $response->json();
        $items = array_map(function (array $player): Player {
            $games = array_map(fn (array $game): Game => new Game(
                name: $game['name'],
                skillLevel: (string) ($game['skill_level'] ?? ''),
            ), $player['games'] ?? []);

            return new Player(
                playerId: $player['player_id'],
                nickname: $player['nickname'],
                status: (string) ($player['status'] ?? ''),
                country: (string) ($player['country'] ?? ''),
                avatar: (string) ($player['avatar'] ?? ''),
                verified: (bool) ($player['verified'] ?? false),
                games: $games,
            );
        }, $data['items'] ?? []);

        return new PaginatedResponse(
            items: $items,
            start: $data['start'] ?? 0,
            end: $data['end'] ?? 0,
        );
    }
}
