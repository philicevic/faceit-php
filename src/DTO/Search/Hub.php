<?php

namespace Philicevic\FaceitPhp\DTO\Search;

class Hub
{
    public function __construct(
        public readonly string $hubId,
        public readonly string $name,
        public readonly string $game,
        public readonly string $region,
        public readonly string $status,
        public readonly int $slots,
    ) {}
}
