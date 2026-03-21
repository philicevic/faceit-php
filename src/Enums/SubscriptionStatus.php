<?php

namespace Philicevic\FaceitPhp\Enums;

enum SubscriptionStatus: string
{
    case Finished = 'finished';
    case Playing = 'playing';
    case Eliminated = 'eliminated';
}
