<?php
require_once __DIR__ . '/Model.php';

class Club extends Model
{

    

    public static $table = 'club';

    public static $id="id";
    public static $name = "name";
    public static $nickname = "nickname";
    public static $logo_path = "logo_path";
    public static $trainer_id = "trainer_id";
    public static $stadium_id = "stadium_id";
    public static $founded_at = "founded_at";
    public static $created_at = "created_at";


    

    public function __construct($id, $name, $nickname, $founded_at, $created_at, $logo = null, $logo_path = null, $trainer = null, $stadium = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->nickname = $nickname;
        $this->founded_at = $founded_at;
        $this->created_at = $created_at;
        $this->logo = $logo;
        $this->logo_path = $logo_path;
        $this->trainer = $trainer;
        $this->stadium = $stadium;
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }

    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }
    }
}
