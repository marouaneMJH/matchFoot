<?php
require_once __DIR__ . '/Model.php';


class Tournament extends Model
{
    public static $table = 'tournament';

    public static $id="id";
    public static $name="name";
    public static $teamNbr="team_count";
    public static $roundNbr="round_count";
    public static $logoPath="logo_path";

    public function __construct($id, $name,$teamNbr,$roundNbr,$logoPath)
    {
        $this->id = $id;
        $this->name = $name;
        $this->teamNbr = $teamNbr;
        $this->roundNbr = $roundNbr;
        $this->logoPath = $logoPath;

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

    public static function getMatchesByTournament($tournament_id): array {
        $query = "SELECT m.*, 
            c1.name as home_team_name, c1.logo_path as home_team_logo,
            c2.name as away_team_name, c2.logo_path as away_team_logo
        FROM game_match m
        JOIN club c1 ON m.club1_id = c1.id
        JOIN club c2 ON m.club2_id = c2.id
        WHERE m.tournament_id = :tournament_id";
        
        $stmt = self::connect()->prepare($query);
        $stmt->execute([':tournament_id' => $tournament_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getGoalsByTournament($tournament_id): array {
        $query = "SELECT g.*, l.match_id, l.club_type, l.player_id
        FROM goal g
        JOIN lineup l ON g.lineup_id = l.id
        JOIN game_match m ON l.match_id = m.id
        WHERE m.tournament_id = :tournament_id";
        
        $stmt = self::connect()->prepare($query);
        $stmt->execute([':tournament_id' => $tournament_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getTeamsByTournament($tournament_id): array {
        $query = "SELECT DISTINCT c.id, c.name, c.logo_path
        FROM club c
        JOIN game_match m ON c.id = m.club1_id OR c.id = m.club2_id
        WHERE m.tournament_id = :tournament_id";
        
        $stmt = self::connect()->prepare($query);
        $stmt->execute([':tournament_id' => $tournament_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getLastFiveMatchesByTeam($team_id): array {
        $query = "SELECT 
            m.id,
            m.club1_id,
            m.club2_id,
            COALESCE(g1.goals, 0) as home_goals,
            COALESCE(g2.goals, 0) as away_goals
        FROM game_match m
        LEFT JOIN (
            SELECT match_id, COUNT(*) as goals
            FROM goal g
            JOIN lineup l ON g.lineup_id = l.id
            WHERE l.club_type = 'home'
            GROUP BY match_id
        ) g1 ON m.id = g1.match_id
        LEFT JOIN (
            SELECT match_id, COUNT(*) as goals
            FROM goal g
            JOIN lineup l ON g.lineup_id = l.id
            WHERE l.club_type = 'away'
            GROUP BY match_id
        ) g2 ON m.id = g2.match_id
        WHERE m.club1_id = :team_id OR m.club2_id = :team_id
        ORDER BY m.date DESC, m.time DESC
        LIMIT 5";
    
        $stmt = self::connect()->prepare($query);
        $stmt->execute([':team_id' => $team_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}