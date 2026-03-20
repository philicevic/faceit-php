<?php

namespace Philicevic\FaceitPhp\DTO\Game;

use Philicevic\FaceitPhp\Validation\ValidatesFields;
use Philicevic\FaceitPhp\Validation\ValidationContext;

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
        ValidationContext::pushPath('GameAssets');
        try {
            static::validateData($data);

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
        } finally {
            ValidationContext::popPath();
        }
    }
}
