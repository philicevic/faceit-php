<?php

namespace Philicevic\FaceitPhp\DTO\Player\Team;

class Member
{
    /**
     * @param  array<string>  $memberships
     */
    public function __construct(
        public string $uuid,
        public string $nickname,
        public string $avatar,
        public string $country,
        public string $faceitUrl,
        public string $membershipType,
        public array $memberships,
        public int $skillLevel,
    ) {}
}
