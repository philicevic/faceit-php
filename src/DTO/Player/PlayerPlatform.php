<?php

namespace Philicevic\FaceitPhp\DTO\Player;

use Philicevic\FaceitPhp\Enums\Platform;

readonly class PlayerPlatform
{
    public function __construct(
        public Platform $platform,
        public string $playerId,
    ) {}

    public static function parse($platform, $playerId): self
    {
        return new self(Platform::from($platform), $playerId);
    }
}
