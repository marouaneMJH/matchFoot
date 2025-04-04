<?php 
require_once __DIR__ . '/Model.php';

class Goal extends Model {
    protected static $table = 'goal';
    public static $id='id';
    public static $lineup_id='lineup_id';
    public static $minute='minute';
    public static $type_id='type_id';
    public static $assistor_id='assistor_id';

    public static function getByMatchID($matchId) {
        $query = "SELECT g.*,l.id as lineup_id,l.club_type,l.is_starting,l.match_id,l.player_id,l.position_id 
        FROM goal g join lineup l on g.lineup_id = l.id WHERE l.match_id = ?";
        $stmt = self::connect()->prepare($query);
        $stmt->execute([$matchId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


   
}