<?php

namespace Philicevic\FaceitPhp\Enums;

enum ClanJoinType: string
{
    case Application = 'application';
    case Invite = 'invite';
    case Public = 'public';
}
