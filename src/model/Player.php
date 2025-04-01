<?php
require_once __DIR__ . '/Model.php';


class Player extends Model
{

    public static $table = 'player';

    public static $id = 'id';
    public static $firstName = 'name';
    public static $lastName = 'surname';
    public static $weight = 'weight';
    public static $height = 'height';
    public static $foot = 'foot';
    public static $birthDate = 'birth_date';
    public static $profilePath = 'profile_path';
    public static $countryId = 'country_id';
    public static $clubId = 'club_id';
    public static $positionId = 'position_id';

    public function __construct($id, $firstName, $lastName, $weight, $height, $birthDate, $profilePath, $countryId, $clubId, $positionId)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->weight = $weight;
        $this->height = $height;
        $this->birthDate = $birthDate;
        $this->profilePath = $profilePath;
        $this->countryId = $countryId;
        $this->clubId = $clubId;
        $this->positionId = $positionId;
    }

    public static function getAllPlayers(): array
    {
        $query = "SELECT p.id, p.name,p.surname,p.weight,p.foot,p.birth_date,p.height,p.profile_path,pos.name AS position_name,c.name AS club_name,c.nickname AS club_nickname,country.name AS country_name,p.number
                FROM player p
                    JOIN position pos ON p.position_id = pos.id
                    JOIN club c ON p.club_id = c.id
                    JOIN country ON p.country_id = country.id";
        $stmt = self::connect()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getHomeClubPlayersByMatch($match_id)
    {
        $query = "SELECT game_match.time, game_match.round, game_match.date, game_match.club1_id, game_match.formation2_id, game_match.stadium_id,stadium.name as stadium_name, club.name as club_name, club.nickname, club.logo_path,  club.id AS club_id, player.name, player.surname,player.profile_path,player.number,player.id AS id, position.tag, position.name as position, position.id AS position_id 
        FROM game_match INNER JOIN club ON club1_id = club.id 
            INNER JOIN player ON club_id = club.id 
            INNER JOIN position ON position_id = position.id  
            join stadium on stadium.id = game_match.stadium_id
        WHERE game_match.id = ?;";
        $stmt = self::connect()->prepare($query);
        $stmt->execute([$match_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAwayClubPlayersByMatch($match_id)
    {
        $query = "SELECT game_match.time, game_match.round, game_match.date, game_match.club2_id, game_match.formation2_id, game_match.stadium_id,stadium.name as stadium_name, club.name as club_name, club.nickname, club.logo_path,  club.id AS club_id, player.name, player.surname,player.profile_path,player.number,player.id AS id, position.tag, position.name as position, position.id AS position_id 
        FROM game_match INNER JOIN club ON club2_id = club.id 
            INNER JOIN player ON club_id = club.id 
            INNER JOIN position ON position_id = position.id  
            INNER JOIN stadium on stadium.id = game_match.stadium_id
        WHERE game_match.id = ?;";
        $stmt = self::connect()->prepare($query);
        $stmt->execute([$match_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
