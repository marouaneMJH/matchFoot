<?php
require_once __DIR__ . '/Model.php';

class GameMatch extends Model
{
    protected static $table = 'game_match';

    public static $id = 'id';
    public static $date = 'date';
    public static $time = 'time';
    public static $round = 'round';
    public static $tournament_id = 'tournament_id';
    public static $club1_id = 'club1_id';
    public static $club2_id = 'club2_id';
    public static $formation1_id = 'formation1_id';
    public static $formation2_id = 'formation2_id';
    public static $stadium_id = 'stadium_id';

    public static function getAllMatches($tournament_id): array
    {
        try {
            $table = self::$table;
            $query = "SELECT $table.*,club.name as club1_name,club.nickname as club1_nickname,club.logo_path as club1_logo_path,club2.name as club2_name,club2.nickname as club2_nickname,club2.logo_path as club2_logo_path,stadium.name as stadium_name,stadium.capacity,city.name as city_name 
            FROM game_match JOIN club ON game_match.club1_id = club.id 
            JOIN club AS club2 ON game_match.club2_id = club2.id 
            JOIN stadium ON game_match.stadium_id = stadium.id 
            JOIN city ON stadium.city_id = city.id 
            Where tournament_id = :tournament_id
            ORDER BY date ASC, time ASC";
            
            $stmt = self::connect()->prepare($query);
            $stmt->execute([':tournament_id' => $tournament_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $error = "Error fetching game matches: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
            return [];
        }
    }
}
