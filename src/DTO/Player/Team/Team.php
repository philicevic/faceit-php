<?php

namespace Philicevic\FaceitPhp\DTO\Player\Team;

class Team
{
    /**
     * @param  array<Member>  $members
     */
    public function __construct(
        public string $uuid,
        public string $name,
        public string $nickname,
        public string $avatar,
        public string $coverImage,
        public string $description,
        public string $faceitUrl,
        public string $game,
        public string $leader,
        public string $teamType,
        public string $chatRoomId,
        public array $members,
    ) {}
}
