<?php
require_once __DIR__ . '/../model/Vote.php';
require_once __DIR__ . '/Controller.php';

class VoteController extends Controller {
    
    public static function getMatchVotes($match_id): array {
        try {
            $votes = Vote::getVotesByMatch($match_id);
            $total = $votes['total_votes'] > 0 ? $votes['total_votes'] : 1;
            
            return [
                'home_percentage' => round(($votes['home_votes'] / $total) * 100),
                'away_percentage' => round(($votes['away_votes'] / $total) * 100),
                'draw_percentage' => round(($votes['draw_votes'] / $total) * 100),
                'total_votes' => $votes['total_votes']
            ];
        } catch (Exception $e) {
            return [
                'home_percentage' => 0,
                'away_percentage' => 0,
                'draw_percentage' => 0,
                'total_votes' => 0
            ];
        }
    }

    public static function submitVote(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['error' => 'Invalid request method']);
            return;
        }

        $user_id = $_SESSION['user_id'] ?? null;
        if (!$user_id) {
            echo json_encode(['error' => 'User not authenticated']);
            return;
        }

        $match_id = $_POST['match_id'] ?? null;
        $vote_value = $_POST['vote'] ?? null;

        if (!$match_id || !in_array($vote_value, ['0', '1', '2'])) {
            echo json_encode(['error' => 'Invalid vote data']);
            return;
        }

        if (Vote::hasUserVoted($user_id, $match_id)) {
            echo json_encode(['error' => 'User has already voted']);
            return;
        }

        try {
            Vote::create([
                Vote::$user_id => $user_id,
                Vote::$match_id => $match_id,
                Vote::$vote => $vote_value
            ]);
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Failed to submit vote']);
        }
    }
}