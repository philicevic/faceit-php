<?php

namespace Philicevic\FaceitPhp\Enums;

enum ChampionshipType: string
{
    case Bracket = 'bracket';
    case DoubleElimination = 'doubleElimination';
    case RoundRobin = 'roundRobin';
    case SingleElimination = 'singleElimination';
}
