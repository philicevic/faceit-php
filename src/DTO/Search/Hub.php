<?php

namespace Philicevic\FaceitPhp\DTO\Search;

use Philicevic\FaceitPhp\Enums\Region;
use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class Hub
{
    use ValidatesFields;

    public function __construct(
        public string $uuid,
        public string $name,
        public string $organizerId,
        public string $organizerName,
        public string $organizerType,
        public string $game,
        public Region $region,
        public int $numberOfMembers
    ) {}

    protected static function fieldSchema(): array
    {
        return [
            'uuid' => 'string',
            'name' => 'string',
            'organizerId' => 'string',
            'organizerName' => 'string',
            'organizerType' => 'string',
            'game' => 'string',
            'region' => Region::class,
            'numberOfMembers' => 'int',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            uuid: $d['competition_id'],
            name: $d['name'],
            organizerId: $d['organizer_id'],
            organizerName: $d['organizer_name'],
            organizerType: $d['organizer_type'],
            game: $d['game'],
            region: Region::from($d['region']),
            numberOfMembers: (int) $d['number_of_members'],
        ));
    }
}
