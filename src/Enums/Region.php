<?php

namespace Philicevic\FaceitPhp\Enums;

enum Region: string
{
    case Europe = 'EU';
    case NorthAmerica = 'NA';
    case SouthAmerica = 'SA';
    case SouthEastAsia = 'SEA';
    case Oceania = 'OCE';
    case Russia = 'RU';
    case UnitedStates = 'US';
    case Canada = 'Canada';
    case Asia = 'ASIA';
    case MEWA = 'MEWA';
    case MiddleEast = 'ME';
    case Global = 'GLOBAL';
    case Latam = 'LATAM';
    case LAS = 'LAS';
    case Africa = 'AF';
    case AsiaPacific = 'APAC';
    case MENA = 'MENA';
    case EUW = 'EUW';
    case EUNE = 'EUNE';
    case TR = 'TR';
    case BR = 'BR';
    case LAN = 'LAN';
    case EMEA = 'EMEA';
    case China = 'China';

    // Weird regions?
    case Xbox = 'XBOX';
    case EuropeMena = 'Europe & MENA';

    public static function fromFlexible(string $value): self
    {
        return self::tryFrom($value)
            ?? self::tryFromAlias($value)
            ?? throw new \ValueError("Invalid region: $value");
    }

    private static function tryFromAlias(string $value): ?self
    {
        return match (strtolower($value)) {
            'oceania', 'oc' => self::Oceania,
            'asia', 'as' => self::Asia,
            'global' => self::Global,
            'north america' => self::NorthAmerica,
            'south america' => self::SouthAmerica,
            default => null,
        };
    }
}
