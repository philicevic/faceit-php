<?php

namespace Philicevic\FaceitPhp\Enums;

enum ChampionshipStatus: string
{
    case Started = 'started';
    case Ongoing = 'ongoing';
    case Upcoming = 'upcoming';
    case Cancelled = 'cancelled';
    case Adjustment = 'adjustment';
    case Paid = 'paid';
    case Join = 'join';
    case Finished = 'finished';
}
