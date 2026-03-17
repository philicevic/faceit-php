<?php

use Philicevic\FaceitPhp\DTO\Player;
use Philicevic\FaceitPhp\Faceit;
use Philicevic\FaceitPhp\Requests\GetPlayerRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    /** @var Faceit $faceit */
    $this->faceit = faceitMock();
});

test('can get player dto', function () {
    MockClient::global([
        GetPlayerRequest::class => MockResponse::fixture('player_details'),
    ]);

    $player = $this->faceit->player()->get('a58f6134-4f31-4611-8431-b0a9630bea77');

    expect($player)->toBeInstanceOf(Player::class);
});

test('player details get populated', function () {
    MockClient::global([
        GetPlayerRequest::class => MockResponse::fixture('player_details'),
    ]);

    $player = $this->faceit->player()->get('a58f6134-4f31-4611-8431-b0a9630bea77');

    expect($player->uuid)->toBeString()
        ->and($player->nickname)->toBeString()
        ->and($player->avatar)->toBeString()
        ->and($player->country)->toBeString()
        ->and($player->coverImage)->toBeString()
        ->and($player->activatedAt)->toBeInstanceOf(DateTime::class);
});

test('player activation date is not empty', function () {
    MockClient::global([
        GetPlayerRequest::class => MockResponse::fixture('player_details'),
    ]);

    $player = $this->faceit->player()->get('a58f6134-4f31-4611-8431-b0a9630bea77');

    expect($player->activatedAt->getTimestamp())->not->toBe(0);
});
