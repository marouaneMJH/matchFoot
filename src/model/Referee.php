<?php
require_once __DIR__ . '/../model/Model.php';

class Referee extends Model{
    
    protected static $table = 'referee';
    public static $id = 'id';
    public static $firstName = 'name';
    public static $lastName = 'surname';
    public static $birthDate = 'birth_date';
    public static $startingDate = 'starting_date';
    public static $country_id = 'country_id';

    public function __construct($id, $firstName, $lastName, $birthDate, $country_id)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthDate = $birthDate;
        $this->country_id = $country_id;
    }

    public static function getAll(): array
    {
        $query = "SELECT r.id, r.name, r.surname, r.birth_date, r.starting_date, c.name AS country_name, c.id AS country_id
                FROM referee r
                JOIN country c ON r.country_id = c.id";
        $stmt = self::connect()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id): array
    {
        $query = "SELECT r.id, r.name, r.surname, r.birth_date, r.starting_date, c.name AS country_name, c.id AS country_id
                FROM referee r
                JOIN country c ON r.country_id = c.id
                WHERE r.id = ?;";
        $stmt = self::connect()->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

}