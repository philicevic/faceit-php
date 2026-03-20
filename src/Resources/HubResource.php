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
use Saloon\Http\BaseResource;

class HubResource extends BaseResource
{
    public function get(string $hubId, ?string $expanded = null): Hub
    {
        $request = new GetHubRequest($hubId, $expanded);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    /**
     * @return PaginatedResponse<Info>
     */
    public function getMatches(string $hubId, ?string $type = null, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        $request = new GetHubMatchesRequest($hubId, $type, $offset, $limit);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    /**
     * @return PaginatedResponse<Member>
     */
    public function getMembers(string $hubId, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        $request = new GetHubMembersRequest($hubId, $offset, $limit);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    /**
     * @return PaginatedResponse<Role>
     */
    public function getRoles(string $hubId, int $offset = 0, int $limit = 20): PaginatedResponse
    {
        $request = new GetHubRolesRequest($hubId, $offset, $limit);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function getRules(string $hubId): Rules
    {
        $request = new GetHubRulesRequest($hubId);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }

    public function getStats(string $hubId, int $offset = 0, int $limit = 20): HubStats
    {
        $request = new GetHubStatsRequest($hubId, $offset, $limit);
        $response = $this->connector->send($request);

        return $request->createDtoFromResponse($response);
    }
}
