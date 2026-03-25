<?php

use Philicevic\FaceitPhp\DTO\Ban;
use Philicevic\FaceitPhp\DTO\Player;
use Philicevic\FaceitPhp\Exceptions\MissingFieldException;
use Philicevic\FaceitPhp\Exceptions\TypeMismatchException;
use Philicevic\FaceitPhp\Exceptions\UnknownFieldException;
use Philicevic\FaceitPhp\Validation\ValidationContext;

$validBan = [
    'user_id' => 'abc-123',
    'nickname' => 'testplayer',
    'reason' => 'cheating',
    'type' => 'permanent',
    'starts_at' => '2023-01-01T00:00:00Z',
    'ends_at' => '2024-01-01T00:00:00Z',
];

afterEach(function () {
    ValidationContext::disable();
});

it('ignores unknown fields in non-strict mode', function () use ($validBan) {
    $data = array_merge($validBan, ['extra_field' => 'some_value']);
    $ban = Ban::fromArray($data);
    expect($ban)->toBeInstanceOf(Ban::class);
    expect($ban->userId)->toBe('abc-123');
});

it('accepts valid data in strict mode', function () use ($validBan) {
    ValidationContext::enable();
    $ban = Ban::fromArray($validBan);
    expect($ban)->toBeInstanceOf(Ban::class);
    expect($ban->userId)->toBe('abc-123');
});

it('throws MissingFieldException for missing required field in strict mode', function () use ($validBan) {
    ValidationContext::enable();
    $data = $validBan;
    unset($data['user_id']);
    Ban::fromArray($data);
})->throws(MissingFieldException::class);

it('MissingFieldException carries correct DTO class and field info', function () use ($validBan) {
    ValidationContext::enable();
    $data = $validBan;
    unset($data['user_id']);
    try {
        Ban::fromArray($data);
    } catch (MissingFieldException $e) {
        expect($e->dtoClass)->toContain('Ban');
        expect($e->getMessage())->toContain('user_id');
        expect($e->violations)->not->toBeEmpty();
    }
});

it('throws TypeMismatchException for wrong type in strict mode', function () use ($validBan) {
    ValidationContext::enable();
    $data = array_merge($validBan, ['user_id' => 12345]);
    Ban::fromArray($data);
})->throws(TypeMismatchException::class);

it('TypeMismatchException carries correct field and type info', function () use ($validBan) {
    ValidationContext::enable();
    $data = array_merge($validBan, ['user_id' => 12345]);
    try {
        Ban::fromArray($data);
    } catch (TypeMismatchException $e) {
        expect($e->dtoClass)->toContain('Ban');
        expect($e->getMessage())->toContain('user_id');
        expect($e->getMessage())->toContain('string');
        expect($e->violations)->not->toBeEmpty();
    }
});

it('throws UnknownFieldException for extra field in strict mode', function () use ($validBan) {
    ValidationContext::enable();
    $data = array_merge($validBan, ['hacker_field' => 'unexpected']);
    Ban::fromArray($data);
})->throws(UnknownFieldException::class);

it('UnknownFieldException carries correct field info', function () use ($validBan) {
    ValidationContext::enable();
    $data = array_merge($validBan, ['hacker_field' => 'unexpected']);
    try {
        Ban::fromArray($data);
    } catch (UnknownFieldException $e) {
        expect($e->dtoClass)->toContain('Ban');
        expect($e->getMessage())->toContain('hacker_field');
        expect($e->violations)->not->toBeEmpty();
    }
});

it('optional fields may be absent in strict mode', function () use ($validBan) {
    ValidationContext::enable();
    // 'game' is optional — omitting it should not throw
    $data = $validBan;
    unset($data['game']);
    $ban = Ban::fromArray($data);
    expect($ban->game)->toBe('');
});

it('validates nested DTOs with correct path in strict mode', function () {
    ValidationContext::enable();
    $data = [
        'player_id' => 'abc-123',
        'nickname' => 'testplayer',
        'activated_at' => '2023-01-01T00:00:00Z',
        'games' => [
            'cs2' => [
                'unknown_game_field' => 'unexpected_value',
            ],
        ],
    ];

    try {
        Player::fromArray($data);
        $this->fail('Expected UnknownFieldException');
    } catch (UnknownFieldException $e) {
        expect($e->getMessage())->toContain('GameProfile');
        expect($e->getMessage())->toContain('unknown_game_field');
    }
});

it('path stack is cleaned up after exception', function () use ($validBan) {
    ValidationContext::enable();
    $data = $validBan;
    unset($data['user_id']);

    try {
        Ban::fromArray($data);
    } catch (MissingFieldException) {
        // swallow
    }

    expect(ValidationContext::currentPath())->toBe('');
});

it('strict mode is disabled by default when constructing Faceit without strict param', function () {
    expect(ValidationContext::isStrict())->toBeFalse();
});

it('faceitMock with strict=true enables strict mode', function () {
    $faceit = faceitMock(strict: true);
    expect(ValidationContext::isStrict())->toBeTrue();
});

it('faceitMock with strict=false disables strict mode', function () {
    faceitMock(strict: true);
    faceitMock(strict: false);
    expect(ValidationContext::isStrict())->toBeFalse();
});
