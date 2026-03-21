<?php

namespace Philicevic\FaceitPhp\Enums;

enum MatchStatus: string
{
    case Scheduled = 'SCHEDULED';
    case Finished = 'FINISHED';
    case Cancelled = 'CANCELLED';
    case Ongoing = 'ONGOING';
}
