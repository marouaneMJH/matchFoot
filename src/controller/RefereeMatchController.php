<?php 
require_once __DIR__ . '/../model/RefereeMatch.php';
require_once __DIR__ . '/Controller.php';

class RefereeMatchController extends Controller
{
    public static function index():array
    {
        $referees = RefereeMatch::getAll();
        if (!$referees) {
            $error = "No referees found";
            include __DIR__ . '/../view/Error.php';
            return [];
        }

        return $referees;
    }

    public static function getAllRefereesByMatch($match_id):array
    {
        $referees = RefereeMatch::getByFields([
            RefereeMatch::$match_id => $match_id,
        ]);
        if (!$referees) {
            $error = "No referees found";
            include __DIR__ . '/../view/Error.php';
            return [];
        }

        return $referees;
    }

    public static function store():void{
        $referees = isset($_POST['referee_data']) ? json_decode($_POST['referee_data'], true) : null;
        $matchId = $_POST['match_id'] ?? null;
        if (empty($matchId) || empty($referees)) {
            $error = "All fields are required";
            include __DIR__ . '/../view/error.php';
            return ;
        }
        // var_dump($referees);
        // die();

        try {
            RefereeMatch::deleteByFields([
                RefereeMatch::$match_id => $matchId,
            ]);
            foreach ($referees as $referee) {
                RefereeMatch::create([
                    RefereeMatch::$referee_id => $referee['referee_id'],
                    RefereeMatch::$match_id => $matchId,
                    RefereeMatch::$role_id => $referee['role_id'],
                ]);
            }
            return;

        } catch (Exception $e) {
            $error = "Error: " . $e->getMessage();
            include __DIR__ . '/../view/error.php';
            return ;
        }
    }

    
}