<?php
require_once __DIR__ . '/Model.php';

class Lineup extends Model
{
    public static $table = 'lineup';
    public static $id = 'id';
    public static $game_match_id = 'match_id';
    public static $club_type = 'club_type';
    public static $position_id = 'position_id';
    public static $player_id = 'player_id';

}