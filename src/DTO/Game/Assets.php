<?php

namespace Philicevic\FaceitPhp\DTO\Game;

class Assets
{
    public function __construct(
        public readonly string $cover,
        public readonly string $featuredImgL,
        public readonly string $featuredImgM,
        public readonly string $featuredImgS,
        public readonly string $flagImgIcon,
        public readonly string $flagImgL,
        public readonly string $flagImgM,
        public readonly string $flagImgS,
        public readonly string $landingPage,
    ) {}
}
