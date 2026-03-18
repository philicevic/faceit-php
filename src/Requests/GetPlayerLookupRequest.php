<?php

namespace Philicevic\FaceitPhp\Requests;

use Philicevic\FaceitPhp\DTO\GameProfile;
use Philicevic\FaceitPhp\DTO\Player;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;

class GetPlayerLookupRequest extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        protected readonly ?string $nickname = null,
        protected readonly ?string $game = null,
        protected readonly ?string $gamePlayerId = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/players';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'nickname' => $this->nickname,
            'game' => $this->game,
            'game_player_id' => $this->gamePlayerId,
        ], static fn (mixed $value): bool => $value !== null);
    }

    public function createDtoFromResponse(Response $response): Player
    {
        $data = $response->json();
        $games = [];

        foreach ($data['games'] ?? [] as $gameId => $game) {
            $games[$gameId] = new GameProfile(
                gameId: $gameId,
                gamePlayerId: (string) ($game['game_player_id'] ?? ''),
                gamePlayerName: (string) ($game['game_player_name'] ?? ''),
                gameProfileId: (string) ($game['game_profile_id'] ?? ''),
                region: (string) ($game['region'] ?? ''),
                skillLevel: (int) ($game['skill_level'] ?? 0),
                skillLevelLabel: (string) ($game['skill_level_label'] ?? ''),
                faceitElo: (int) ($game['faceit_elo'] ?? 0),
                regions: is_array($game['regions'] ?? null) ? $game['regions'] : [],
            );
        }

        return new Player(
            uuid: $data['player_id'],
            nickname: $data['nickname'],
            avatar: (string) ($data['avatar'] ?? ''),
            country: (string) ($data['country'] ?? ''),
            coverImage: (string) ($data['cover_image'] ?? ''),
            activatedAt: new \DateTime($data['activated_at']),
            faceitUrl: (string) ($data['faceit_url'] ?? ''),
            friendsIds: $data['friends_ids'] ?? [],
            games: $games,
            memberships: $data['memberships'] ?? [],
            platforms: $data['platforms'] ?? [],
            membershipType: (string) ($data['membership_type'] ?? ''),
            steamId64: (string) ($data['steam_id_64'] ?? ''),
            steamNickname: (string) ($data['steam_nickname'] ?? ''),
            verified: (bool) ($data['verified'] ?? false),
        );
    }
}
