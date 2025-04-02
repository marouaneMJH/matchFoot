<?php 
require_once __DIR__ . '/../model/Lineup.php';
require_once __DIR__ . '/../model/GameMatch.php';
require_once __DIR__ . '/Controller.php';
class LineupController extends Controller
{

    public static function getAllLineups(): array
    {
        if (!isset($_GET['match_id'])) {
            return [];
        }

        $matchId = intval($_GET['match_id']);
        $lineups = Lineup::getByFields([
            Lineup::$game_match_id => $matchId,
        ]);

        if ($lineups) {
            return $lineups;
        } else {
            return [];
        }
    }


    public static function storeAllLineups():void{
        if(! $_SERVER['REQUEST_METHOD'] === 'POST'){
           $error = "Invalid request method";
           include __DIR__ . '/../view/error.php';
              return ;
        }

        $matchId = $_POST['match_id'] ?? null;
        $formation1Id = $_POST['home_team_formation'] ?? null;
        $formation2Id = $_POST['away_team_formation'] ?? null;
        $lineups = $_POST['lineup_data'] ?? null;
        $referees = $_POST['referee_data'] ?? null;

        if (empty($matchId) || empty($lineups)) {
            $error = "All fields are required";
            include __DIR__ . '/../view/error.php';
            return ;
        }

        try {
            Lineup::deleteByFields([
                Lineup::$game_match_id => $matchId,
            ]);
            GameMatch::update($matchId, [
                GameMatch::$formation1_id => $formation1Id,
                GameMatch::$formation2_id => $formation2Id,
            ]);
            echo "Update successful";
            echo $lineups;
            $lineups = json_decode($lineups, true);
            // var_dump($lineups);
            // die();
        
            foreach ($lineups as $lineup) {
                Lineup::create([
                    Lineup::$game_match_id => $matchId,
                    Lineup::$club_type => $lineup['club_type'],
                    Lineup::$is_starting => $lineup['is_starting'],
                    Lineup::$position_id => $lineup['position_id'],
                    Lineup::$player_id => $lineup['player_id'],
                ]);
            }
            return;

        } catch (Exception $e) {
            $error = "Error creating lineup: " . $e->getMessage();
            include __DIR__ . '/../view/error.php';
            return;
        }
    }

    public static function getLineupByMatchId($matchId): array
    {
        $lineups = Lineup::getLineupByMatchId($matchId);
        if ($lineups) {
            return $lineups;
        } else {
            return [];
        }
    }
}