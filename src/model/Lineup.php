<?php
require_once __DIR__ . '/Model.php';

class Lineup extends Model
{
    public static $table = 'lineup';
    public static $id = 'id';
    public static $game_match_id = 'match_id';
    public static $club_type = 'club_type';
    public static $is_starting ='is_starting';
    public static $position_id = 'position_id';
    public static $player_id = 'player_id';


    public static function getLineupByMatchId($matchId){
        $query = "SELECT l.id,p.position_id,pos.tag,pos.name,p.id,p.name,p.surname,p.number
                FROM lineup l JOIN position pos ON l.position_id = pos.id
                        JOIN game_match gm ON l.match_id = gm.id
                        JOIN player p ON l.player_id = p.id";
        $stmt = self::connect()->prepare($query);
        $stmt->execute([$matchId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}