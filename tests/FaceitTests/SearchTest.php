<?php

use Philicevic\FaceitPhp\DTO\PaginatedResponse;
use Philicevic\FaceitPhp\DTO\Search\Championship;
use Philicevic\FaceitPhp\DTO\Search\Clan;
use Philicevic\FaceitPhp\DTO\Search\Hub;
use Philicevic\FaceitPhp\DTO\Search\Organizer;
use Philicevic\FaceitPhp\DTO\Search\Player;
use Philicevic\FaceitPhp\DTO\Search\PlayerGame;
use Philicevic\FaceitPhp\DTO\Search\Team;
use Philicevic\FaceitPhp\DTO\Search\Tournament;
use Philicevic\FaceitPhp\Enums\ChampionshipStatus;
use Philicevic\FaceitPhp\Enums\ClanJoinType;
use Philicevic\FaceitPhp\Enums\Region;
use Philicevic\FaceitPhp\Enums\SearchType;
use Philicevic\FaceitPhp\Faceit;
use Philicevic\FaceitPhp\Requests\SearchChampionshipsRequest;
use Philicevic\FaceitPhp\Requests\SearchClansRequest;
use Philicevic\FaceitPhp\Requests\SearchHubsRequest;
use Philicevic\FaceitPhp\Requests\SearchOrganizersRequest;
use Philicevic\FaceitPhp\Requests\SearchPlayersRequest;
use Philicevic\FaceitPhp\Requests\SearchTeamsRequest;
use Philicevic\FaceitPhp\Requests\SearchTournamentsRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    /** @var Faceit $faceit */
    $this->faceit = faceitMock();
});

test('can search players', function () {
    MockClient::global([
        SearchPlayersRequest::class => MockResponse::fixture('search_players'),
    ]);

    $result = $this->faceit->search('ZywOo');

    expect($result)->toBeInstanceOf(PaginatedResponse::class)
        ->and($result->items)->toContainOnlyInstancesOf(Player::class);
});

test('search players hydrate all attributes', function () {
    MockClient::global([
        SearchPlayersRequest::class => MockResponse::fixture('search_players'),
    ]);

    $result = $this->faceit->search('ZywOo');

    foreach ($result->items as $player) {
        expect($player->nickname)->toBeString()->not->toBeEmpty()
            ->and($player->playerId)->toBeString()->not->toBeEmpty()
            ->and($player->avatar)->toBeString()
            ->and($player->country)->toBeString()->not->toBeEmpty()
            ->and($player->status)->toBeString()
            ->and($player->verified)->toBeBool()
            ->and($player->games)->toContainOnlyInstancesOf(PlayerGame::class);

        foreach ($player->games as $game) {
            expect($game->name)->toBeString()->not->toBeEmpty()
                ->and($game->skillLevel)->toBeInt();
        }
    }
});

test('paginated response supports array access', function () {
    MockClient::global([
        SearchPlayersRequest::class => MockResponse::fixture('search_players'),
    ]);

    $result = $this->faceit->search('ZywOo');

    expect($result[0])->toBeInstanceOf(Player::class)
        ->and($result['items'])->toContainOnlyInstancesOf(Player::class);
});

test('can search tournaments', function () {
    MockClient::global([
        SearchTournamentsRequest::class => MockResponse::fixture('search_tournaments'),
    ]);

    $result = $this->faceit->search('Points', SearchType::Tournament, 0, 100);

    foreach ($result->items as $tournament) {
        expect($tournament->uuid)->toBeString()->not->toBeEmpty()
            ->and($tournament->name)->toBeString()->not->toBeEmpty()
            ->and($tournament->game)->toBeString()->not->toBeEmpty()
            ->and($tournament->region)->toBeIn(Region::cases())
            ->and($tournament->organizerId)->toBeString()->not->toBeEmpty()
            ->and($tournament->organizerName)->toBeString()->not->toBeEmpty()
            ->and($tournament->organizerType)->toBeString()
            ->and($tournament->status)->toBeIn(ChampionshipStatus::cases())
            ->and($tournament->prizeType)->when($tournament->prizeType != null, fn ($t) => $t->toBeString())
            ->and($tournament->totalPrize)->when($tournament->totalPrize != null, fn ($t) => $t->toBeString())
            ->and($tournament->playersJoined)->toBeInt()
            ->and($tournament->numberOfMembers)->toBeInt()
            ->and($tournament->type)->toBeString();
    }

    expect($result)->toBeInstanceOf(PaginatedResponse::class)
        ->and($result->items)->toContainOnlyInstancesOf(Tournament::class);
});

test('can search championships', function () {
    MockClient::global([
        SearchChampionshipsRequest::class => MockResponse::fixture('search_championships'),
    ]);

    $result = $this->faceit->search('Spring', SearchType::Championship, 0, 100);

    expect($result)->toBeInstanceOf(PaginatedResponse::class)
        ->and($result->items)->toContainOnlyInstancesOf(Championship::class);

    foreach ($result->items as $champ) {
        expect($champ->uuid)->toBeString()->not->toBeEmpty()
            ->and($champ->name)->toBeString()->not->toBeEmpty()
            ->and($champ->game)->toBeString()->not->toBeEmpty()
            ->and($champ->region)->toBeIn(Region::cases())
            ->and($champ->organizerId)->toBeString()->not->toBeEmpty()
            ->and($champ->organizerName)->toBeString()->not->toBeEmpty()
            ->and($champ->organizerType)->toBeString()
            ->and($champ->status)->toBeIn(ChampionshipStatus::cases())
            ->and($champ->prizeType)->when($champ->prizeType != null, fn ($t) => $t->toBeString())
            ->and($champ->totalPrize)->when($champ->totalPrize != null, fn ($t) => $t->toBeString())
            ->and($champ->playersJoined)->toBeInt()
            ->and($champ->numberOfMembers)->toBeInt()
            ->and($champ->type)->toBeString();
    }

});

test('can search clans', function () {
    MockClient::global([
        SearchClansRequest::class => MockResponse::fixture('search_clans'),
    ]);

    $result = $this->faceit->search('Vitality', SearchType::Clan);

    expect($result)->toBeInstanceOf(PaginatedResponse::class)
        ->and($result->items)->toContainOnlyInstancesOf(Clan::class);

    /** @var Clan $clan */
    foreach ($result->items as $clan) {
        expect($clan->uuid)->toBeString()->not->toBeEmpty()
            ->and($clan->name)->toBeString()->not->toBeEmpty()
            ->and($clan->game)->toBeString()->not->toBeEmpty()
            ->and($clan->type)->toBeString()
            ->and($clan->avatar)->toBeString()
            ->and($clan->region)->toBeIn(Region::cases())
            ->and($clan->minSkillLevel)->toBeInt()
            ->and($clan->maxSkillLevel)->toBeInt()
            ->and($clan->organizerId)->toBeString()->not->toBeEmpty()
            ->and($clan->joinType)->toBeIn(ClanJoinType::cases())
            ->and($clan->membersCount)->toBeInt();
    }
});

test('can search hubs', function () {
    MockClient::global([
        SearchHubsRequest::class => MockResponse::fixture('search_hubs'),
    ]);

    $result = $this->faceit->search('EU CS2', SearchType::Hub, 0, 100);
    expect($result)->toBeInstanceOf(PaginatedResponse::class)
        ->and($result->items)->toContainOnlyInstancesOf(Hub::class);

    foreach ($result->items as $hub) {
        expect($hub->uuid)->toBeString()->not->toBeEmpty()
            ->and($hub->name)->toBeString()->not->toBeEmpty()
            ->and($hub->organizerId)->toBeString()->not->toBeEmpty()
            ->and($hub->organizerName)->toBeString()->not->toBeEmpty()
            ->and($hub->organizerType)->toBeString()->not->toBeEmpty()
            ->and($hub->game)->toBeString()->not->toBeEmpty()
            ->and($hub->region)->toBeIn(Region::cases())
            ->and($hub->numberOfMembers)->toBeInt();
    }
});

test('can search organizers', function () {
    MockClient::global([
        SearchOrganizersRequest::class => MockResponse::fixture('search_organizers'),
    ]);

    $result = $this->faceit->search('Dreamhack', SearchType::Organizer, 0, 100);

    expect($result)->toBeInstanceOf(PaginatedResponse::class)
        ->and($result->items)->toContainOnlyInstancesOf(Organizer::class);

    foreach ($result->items as $organizer) {
        expect($organizer->organizerId)->toBeString()->not->toBeEmpty()
            ->and($organizer->name)->toBeString()->not->toBeEmpty()
            ->and($organizer->avatar)->toBeString()
            ->and($organizer->active)->toBeBool()
            ->and($organizer->games)->toBeArray()
            ->and($organizer->regions)->toBeArray()->each->toBeIn(Region::cases());
    }
});

test('can search teams', function () {
    MockClient::global([
        SearchTeamsRequest::class => MockResponse::fixture('search_teams'),
    ]);

    $result = $this->faceit->search('Vitality', SearchType::Team);

    expect($result)->toBeInstanceOf(PaginatedResponse::class)
        ->and($result->items)->toContainOnlyInstancesOf(Team::class);

    foreach ($result->items as $team) {
        expect($team->teamId)->toBeString()->not->toBeEmpty()
            ->and($team->name)->toBeString()->not->toBeEmpty()
            ->and($team->game)->toBeString()->not->toBeEmpty()
            ->and($team->avatar)->toBeString()
            ->and($team->faceitUrl)->toBeString()->not->toBeEmpty()
            ->and($team->verified)->toBeBool();
    }
});

test('invalid filters throw exception', function () {
    expect(fn () => $this->faceit->search('xqsp4m', filters: ['invalid_key' => 'value']))
        ->toThrow(InvalidArgumentException::class);
});
