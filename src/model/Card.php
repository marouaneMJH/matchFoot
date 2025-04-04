<?php
require_once __DIR__ . '/Model.php';

class Card extends Model {

    public static $table = 'card';
    public static $id = 'id';
    public static $type = 'type';
    public static $lineup_id = 'lineup_id';
    public static $minute = 'minute';

    public static function getByMatchID($matchId) {
        $query = "SELECT c.*,l.id as lineup_id,l.club_type,l.is_starting,l.match_id,l.player_id,l.position_id 
        FROM card c join lineup l on c.lineup_id = l.id WHERE l.match_id = ?";
        $stmt = self::connect()->prepare($query);
        $stmt->execute([$matchId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}