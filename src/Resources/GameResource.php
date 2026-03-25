<?php

namespace Philicevic\FaceitPhp\Resources;

use Philicevic\FaceitPhp\DTO\Game\Game;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\Requests\GetGameRequest;
use Philicevic\FaceitPhp\Requests\GetGamesRequest;

class GameResource extends FaceitResource
{
    /**
     * @return PaginatedResponse<Game>
     */
    public function list(int $offset = 0, int $limit = 20): PaginatedResponse
    {
        return $this->send(new GetGamesRequest($offset, $limit));
    }

    public function get(string $gameId): Game
    {
        return $this->send(new GetGameRequest($gameId));
    }
}
