<?php

namespace Philicevic\FaceitPhp\DTO\Game;

use Philicevic\FaceitPhp\Validation\ValidatesFields;

readonly class GameAssets
{
    use ValidatesFields;

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

    protected static function fieldSchema(): array
    {
        return [
            'cover' => '?string',
            'featured_img_l' => '?string',
            'featured_img_m' => '?string',
            'featured_img_s' => '?string',
            'flag_img_icon' => '?string',
            'flag_img_l' => '?string',
            'flag_img_m' => '?string',
            'flag_img_s' => '?string',
            'landing_page' => '?string',
        ];
    }

    public static function fromArray(array $data): self
    {
        return static::validated($data, fn ($d) => new self(
            cover: (string) ($d['cover'] ?? ''),
            featuredImgL: (string) ($d['featured_img_l'] ?? ''),
            featuredImgM: (string) ($d['featured_img_m'] ?? ''),
            featuredImgS: (string) ($d['featured_img_s'] ?? ''),
            flagImgIcon: (string) ($d['flag_img_icon'] ?? ''),
            flagImgL: (string) ($d['flag_img_l'] ?? ''),
            flagImgM: (string) ($d['flag_img_m'] ?? ''),
            flagImgS: (string) ($d['flag_img_s'] ?? ''),
            landingPage: (string) ($d['landing_page'] ?? ''),
        ));
    }
}
