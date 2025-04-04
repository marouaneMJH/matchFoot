<?php
require_once __DIR__ . '/Model.php';

class Vote extends Model {
    protected static $table = 'vote';
    public static $id='id';
    public static $user_id='user_id';
    public static $match_id='match_id';
    public static $vote='vote'; // 1 for home team, 2 for away team, 0 for draw

    public static function getVotesByMatch($match_id): array {
        $query = "SELECT 
            COUNT(CASE WHEN vote = 1 THEN 1 END) as home_votes,
            COUNT(CASE WHEN vote = 2 THEN 1 END) as away_votes,
            COUNT(CASE WHEN vote = 0 THEN 1 END) as draw_votes,
            COUNT(*) as total_votes
        FROM vote 
        WHERE match_id = :match_id";
        
        $stmt = self::connect()->prepare($query);
        $stmt->execute([':match_id' => $match_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function hasUserVoted($user_id, $match_id): bool {
        $query = "SELECT COUNT(*) as vote_count 
                 FROM vote 
                 WHERE user_id = :user_id AND match_id = :match_id";
        
        $stmt = self::connect()->prepare($query);
        $stmt->execute([
            ':user_id' => $user_id,
            ':match_id' => $match_id
        ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['vote_count'] > 0;
    }
}