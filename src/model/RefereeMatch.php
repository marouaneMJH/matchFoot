<?php
require_once __DIR__ . '/Model.php';

class RefereeMatch extends Model {
    protected $table = 'referee_match';

    public static $id = 'id';
    public static $referee_id = 'referee_id';
    public static $match_id = 'match_id';

    
}