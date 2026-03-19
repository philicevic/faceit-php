<?php

namespace Philicevic\FaceitPhp\DTO\Search;

readonly class Hub
{
    public function __construct(
        public string $hubId,
        public string $name,
        public string $game,
        public string $region,
        public string $status,
        public int $slots,
    ) {}
}
