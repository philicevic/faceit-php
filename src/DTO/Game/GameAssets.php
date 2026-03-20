<?php

namespace Philicevic\FaceitPhp\DTO\Game;

readonly class GameAssets
{
    public function __construct(
        public string $cover,
        public string $featuredImgL,
        public string $featuredImgM,
        public string $featuredImgS,
        public string $flagImgIcon,
        public string $flagImgL,
        public string $flagImgM,
        public string $flagImgS,
        public string $landingPage,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            cover: (string) ($data['cover'] ?? ''),
            featuredImgL: (string) ($data['featured_img_l'] ?? ''),
            featuredImgM: (string) ($data['featured_img_m'] ?? ''),
            featuredImgS: (string) ($data['featured_img_s'] ?? ''),
            flagImgIcon: (string) ($data['flag_img_icon'] ?? ''),
            flagImgL: (string) ($data['flag_img_l'] ?? ''),
            flagImgM: (string) ($data['flag_img_m'] ?? ''),
            flagImgS: (string) ($data['flag_img_s'] ?? ''),
            landingPage: (string) ($data['landing_page'] ?? ''),
        );
    }
}
