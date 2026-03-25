<?php

namespace Philicevic\FaceitPhp\DTO\Team;

readonly class StatSegment
{
    public function __construct(
        public string $type,
        public string $mode,
        public string $label,
        public string $imgSmall,
        public string $imgRegular,
        public array $stats,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['type'],
            $data['mode'],
            $data['label'],
            $data['img_small'],
            $data['img_regular'],
            $data['stats'],
        );
    }
}
