<?php

namespace Philicevic\FaceitPhp\Enums;

enum SearchType: string
{
    case Championship = 'championships';
    case Clan = 'clans';
    case Hub = 'hubs';
    case Organizer = 'organizers';
    case Player = 'players';
    case Team = 'teams';
    case Tournament = 'tournaments';
}
