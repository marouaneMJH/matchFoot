<?php
require_once __DIR__ . '/Model.php';
class Stadium extends Model
{

    

    public static $table = 'stadium';

    public static $id = 'id';
    public static $name = 'name';
    public static $capacity = 'capacity';
    public static $city_id = 'city_id';

    public function __construct($id, $name, $capacity, $city)
    {
        $this->id = $id;
        $this->name = $name;
        $this->capacity = $capacity;
        $this->city = $city;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }


    public static function getStadByName($name): array
    {
        try {
            $table = self::$table;
            $pdo = self::connect();
            $stmt = $pdo->prepare("SELECT * FROM `$table` WHERE nom = :name");
            $stmt->execute(['name' => $name]);
            $stadData = $stmt->fetch(PDO::FETCH_ASSOC);
            return $stadData;
        } catch (PDOException $e) {
            throw new Exception("Error fetching stad: " . $e->getMessage());
        }
    }

}
