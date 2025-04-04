<?php 
require_once __DIR__ . '/Model.php';

class Substitution extends Model {
    protected static $table = 'substitution';
    public static $id='id';
    public static $lineup1_id='lineup_1_id';
    public static $lineup2_id='lineup_2_id';
    public static $minute='minute';

    public static function getByMatchID($matchId) {
        $query = "SELECT s.*,l1.id as lineup_1_id,l1.club_type as club_type_1,l1.is_starting as is_starting_1,l1.match_id as match_id_1,l1.player_id as player_id_1,l1.position_id as position_id_1,
        l2.id as lineup_2_id,l2.club_type as club_type_2,l2.is_starting as is_starting_2,l2.match_id as match_id_2,l2.player_id as player_id_2,l2.position_id as position_id_2 
        FROM substitution s join lineup l1 on s.lineup_1_id = l1.id join lineup l2 on s.lineup_2_id = l2.id WHERE l1.match_id = ?";
        $stmt = self::connect()->prepare($query);
        $stmt->execute([$matchId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}