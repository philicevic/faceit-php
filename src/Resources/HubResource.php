<?php

namespace Philicevic\FaceitPhp\Resources;

use Philicevic\FaceitPhp\DTO\Hub\Hub;
use Philicevic\FaceitPhp\DTO\Hub\HubStats;
use Philicevic\FaceitPhp\DTO\Hub\Member;
use Philicevic\FaceitPhp\DTO\Hub\Role;
use Philicevic\FaceitPhp\DTO\Hub\Rules;
use Philicevic\FaceitPhp\DTO\Match\Detail\Info;
use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\Requests\GetHubMatchesRequest;
use Philicevic\FaceitPhp\Requests\GetHubMembersRequest;
use Philicevic\FaceitPhp\Requests\GetHubRequest;
use Philicevic\FaceitPhp\Requests\GetHubRolesRequest;
use Philicevic\FaceitPhp\Requests\GetHubRulesRequest;
use Philicevic\FaceitPhp\Requests\GetHubStatsRequest;

class HubResource extends FaceitResource
{
    public function get(string $hubId, ?string $expanded = null): Hub
    {
        return $this->send(new GetHubRequest($hubId, $expanded));
    }

    /**
     * @return PaginatedResponse<Info>
     */
    public function getMatches(string $hubId, ?string $type = null, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        return $this->send(new GetHubMatchesRequest($hubId, $type, $offset, $limit));
    }

    /**
     * @return PaginatedResponse<Member>
     */
    public function getMembers(string $hubId, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        return $this->send(new GetHubMembersRequest($hubId, $offset, $limit));
    }

    /**
     * @return PaginatedResponse<Role>
     */
    public function getRoles(string $hubId, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        return $this->send(new GetHubRolesRequest($hubId, $offset, $limit));
    }

    public function getRules(string $hubId): Rules
    {
        return $this->send(new GetHubRulesRequest($hubId));
    }

    public function getStats(string $hubId, int $offset = 0, int $limit = 20): HubStats
    {
        return $this->send(new GetHubStatsRequest($hubId, $offset, $limit));
    }
}
