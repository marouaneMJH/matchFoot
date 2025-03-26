<?php 
require_once __DIR__ . '/Model.php';

class GameMatch extends Model {
    protected $table = 'match';

    public static $id = 'id';
    public static $date = 'date';
    public static $time = 'time';
    public static $round = 'round';
    public static $tournament_id = 'tournament_id';
    public static $club1_id = 'club1_id';
    public static $club2_id = 'club2_id';
    public static $stadium_id = 'stadium_id';

    

}