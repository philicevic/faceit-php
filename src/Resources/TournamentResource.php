<?php

namespace Philicevic\FaceitPhp\Resources;

use Philicevic\FaceitPhp\DTO\Match\Detail\Info;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Player\Tournament as TournamentSimple;
use Philicevic\FaceitPhp\DTO\Tournament\Brackets;
use Philicevic\FaceitPhp\DTO\Tournament\Teams;
use Philicevic\FaceitPhp\DTO\Tournament\Tournament;
use Philicevic\FaceitPhp\Requests\GetTournamentBracketsRequest;
use Philicevic\FaceitPhp\Requests\GetTournamentMatchesRequest;
use Philicevic\FaceitPhp\Requests\GetTournamentRequest;
use Philicevic\FaceitPhp\Requests\GetTournamentsRequest;
use Philicevic\FaceitPhp\Requests\GetTournamentTeamsRequest;

class TournamentResource extends FaceitResource
{
    /**
     * @return PaginatedResponse<TournamentSimple>
     */
    public function list(?string $game = null, ?string $region = null, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        return $this->send(new GetTournamentsRequest($game, $region, $offset, $limit));
    }

    public function get(string $tournamentId, ?string $expanded = null): Tournament
    {
        return $this->send(new GetTournamentRequest($tournamentId, $expanded));
    }

    public function getBrackets(string $tournamentId): Brackets
    {
        return $this->send(new GetTournamentBracketsRequest($tournamentId));
    }

    /**
     * @return PaginatedResponse<Info>
     */
    public function getMatches(string $tournamentId, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        return $this->send(new GetTournamentMatchesRequest($tournamentId, $offset, $limit));
    }

    public function getTeams(string $tournamentId, int $offset = 0, int $limit = 20): Teams
    {
        return $this->send(new GetTournamentTeamsRequest($tournamentId, $offset, $limit));
    }
}
