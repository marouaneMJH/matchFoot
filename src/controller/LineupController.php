<?php 
require_once __DIR__ . '/../model/Lineup.php';
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
        $lineups = $_POST['lineup_data'] ?? null;

        if (empty($matchId) || empty($lineups)) {
            $error = "All fields are required";
            include __DIR__ . '/../view/error.php';
            return ;
        }

        try {
            Lineup::deleteByFields([
                Lineup::$game_match_id => $matchId,
            ]);

            foreach ($lineups as $lineup) {
                Lineup::create([
                    Lineup::$game_match_id => $matchId,
                    Lineup::$club_type => $lineup['club_type'],
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
}