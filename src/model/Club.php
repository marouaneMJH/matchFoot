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


    public static function subscribeByUserId($userId): bool
    {
        $query = "INSERT INTO subscription(user_id, team_id) VALUES(:user_id, :team_id)";
        $stmt = parent::connect();
        $stmt = $stmt->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':team_id', self::$id);
        
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }


    /**
     * Check if a user is subscribed to this club
     * 
     * @param int $userId The user ID to check
     * @return bool True if the user is subscribed, false otherwise
     */
    public static function isUserSubscribed($userId): bool
    {
        $query = "SELECT COUNT(*) FROM subscription WHERE user_id = :user_id AND team_id = :team_id";
        $stmt = parent::connect();
        $stmt = $stmt->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':team_id', self::$id);
        
        $stmt->execute();
        return (int)$stmt->fetchColumn() > 0;
    }

    /**
     * Unsubscribe a user from this club
     * 
     * @param int $userId The user ID to unsubscribe
     * @return bool True if successful, false otherwise
     */
    public static function unsubscribeByUserId($userId): bool
    {
        $query = "DELETE FROM subscription WHERE user_id = :user_id AND team_id = :team_id";
        $stmt = parent::connect();
        $stmt = $stmt->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':team_id', self::$id);
        
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }


}
