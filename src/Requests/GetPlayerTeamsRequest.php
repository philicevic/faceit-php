<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Player\Team\Member;
use Philicevic\FaceitPhp\DTO\Player\Team\Team;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetPlayerTeamsRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly string $playerId,
        protected readonly int $offset = 0,
        protected readonly int $limit = 20,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/players/'.$this->playerId.'/teams';
    }

    protected function defaultQuery(): array
    {
        return [
            'offset' => $this->offset,
            'limit' => $this->limit,
        ];
    }

    /**
     * @return PaginatedResponse<Team>
     */
    public function createDtoFromResponse(Response $response): PaginatedResponse
    {
        $data = $response->json();
        $items = array_map(function (array $team): Team {
            $members = array_map(function (array $member): Member {
                return new Member(
                    uuid: $member['user_id'],
                    nickname: $member['nickname'],
                    avatar: (string) ($member['avatar'] ?? ''),
                    country: (string) ($member['country'] ?? ''),
                    faceitUrl: (string) ($member['faceit_url'] ?? ''),
                    membershipType: (string) ($member['membership_type'] ?? ''),
                    memberships: $member['memberships'] ?? [],
                    skillLevel: (int) ($member['skill_level'] ?? 0),
                );
            }, $team['members'] ?? []);

            return new Team(
                uuid: $team['team_id'],
                name: (string) ($team['name'] ?? ''),
                nickname: (string) ($team['nickname'] ?? ''),
                avatar: (string) ($team['avatar'] ?? ''),
                coverImage: (string) ($team['cover_image'] ?? ''),
                description: (string) ($team['description'] ?? ''),
                faceitUrl: (string) ($team['faceit_url'] ?? ''),
                game: (string) ($team['game'] ?? ''),
                leader: (string) ($team['leader'] ?? ''),
                teamType: (string) ($team['team_type'] ?? ''),
                chatRoomId: (string) ($team['chat_room_id'] ?? ''),
                members: $members,
            );
        }, $data['items'] ?? []);

        return new PaginatedResponse(
            items: $items,
            start: $data['start'] ?? 0,
            end: $data['end'] ?? 0,
        );
    }
}
