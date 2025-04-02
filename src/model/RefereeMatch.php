<?php
require_once __DIR__ . '/Model.php';

class RefereeMatch extends Model {
    protected static $table = 'referee_match';

    public static $id = 'id';
    public static $referee_id = 'referee_id';
    public static $match_id = 'match_id';
    public static $role_id = 'role_id';

    // public static function getAll(): array {
    //     $query = "  SELECT * 
    //                 FROM referee_match rm JOIN  ";
    //     $stmt = self::connect()->prepare($query);
    //     $stmt->execute();
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    
}