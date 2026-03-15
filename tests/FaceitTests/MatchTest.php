<?php

use Philicevic\FaceitPhp\Requests\GetMatchDetailsRequest;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function () {
    $this->faceit = faceitMock();
});

test('can get match details', function () {
    MockClient::global([
        GetMatchDetailsRequest::class => MockResponse::fixture('match_details'),
    ]);

    $match = $this->faceit->match()->get('1-bb13fd78-e183-4d37-8a4b-ceed67da5265');

    expect($match)->toBeInstanceOf(\Philicevic\FaceitPhp\DTO\MatchInfo::class);
});