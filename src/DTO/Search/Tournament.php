<?php

namespace Philicevic\FaceitPhp\DTO\Search;

use Philicevic\FaceitPhp\Enums\ChampionshipStatus;
use Philicevic\FaceitPhp\Enums\Region;

readonly class Tournament
{
    public function __construct(
        public string $uuid,
        public string $name,
        public string $game,
        public Region $region,
        public string $organizerId,
        public string $organizerName,
        public string $organizerType,
        public ChampionshipStatus $status,
        public ?string $prizeType,
        public ?string $totalPrize,
        public int $playersJoined,
        public int $numberOfMembers,
        public string $type,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            uuid: $data['competition_id'],
            name: $data['name'],
            game: $data['game'],
            region: Region::from($data['region']),
            organizerId: $data['organizer_id'],
            organizerName: $data['organizer_name'],
            organizerType: $data['organizer_type'],
            status: ChampionshipStatus::from($data['status']),
            prizeType: $data['prize_type'] ?? null,
            totalPrize: $data['total_prize'] ?? null,
            playersJoined: $data['players_joined'],
            numberOfMembers: $data['number_of_members'],
            type: $data['competition_type'],
        );
    }
}
