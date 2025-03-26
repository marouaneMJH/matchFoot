<?php
require_once __DIR__ . '/../model/GameMatch.php';

class GameMatchController extends Controller
{
    public static function index(): array
    {
        try {
            $gameMatches = GameMatch::getAll();
            return $gameMatches;
        } catch (Exception $e) {
            $error = "Error fetching game matches: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
            return [];
        }
    }

    public static function getGameMatchById($id): array
    {
        try {
            $gameMatch = GameMatch::getById($id);
        } catch (Exception $e) {
            $error = "Error fetching game match: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
            return [];
        }
        if (!$gameMatch) {
            $error = "Game match not found";
            include __DIR__ . '/../view/Error.php';
            return [];
        }

        return $gameMatch;
    }

    public static function getByTournament($tournament_id): array
    {
        if (!$tournament_id) {
            $error = "Invalid tournament id";
            include __DIR__ . '/../view/Error.php';
            return [];
        }

        try {
            $gameMatches = GameMatch::getByFields(GameMatch::$tournament_id, $tournament_id);
        } catch (Exception $e) {
            $error = "Error fetching game matches: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
            return [];
        }
        return $gameMatches;
    }

    public static function store(): array
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $error = "Invalid request method";
            include __DIR__ . '/../view/Error.php';
            return [];
        }
        $date = isset($_POST['date']) ? $_POST['date'] : null;
        $time = isset($_POST['time']) ? $_POST['time'] : null;
        $round = isset($_POST['round']) ? $_POST['round'] : null;
        $tournament_id = isset($_POST['tournament_id']) ? $_POST['tournament_id'] : null;
        $club1_id = isset($_POST['club1_id']) ? $_POST['club1_id'] : null;
        $club2_id = isset($_POST['club2_id']) ? $_POST['club2_id'] : null;
        $referee_ids = isset($_POST['referee_id']) ? $_POST['referee_id[]'] : null;
        $stadium_id = isset($_POST['stadium_id']) ? $_POST['stadium_id'] : null;


        $data = [
            GameMatch::$date => $date,
            GameMatch::$time => $time,
            GameMatch::$round => $round,
            GameMatch::$tournament_id => $tournament_id,
            GameMatch::$club1_id => $club1_id,
            GameMatch::$club2_id => $club2_id,
            GameMatch::$stadium_id => $stadium_id,
        ];

        $rules = [
            GameMatch::$date => 'required',
            GameMatch::$time => 'required',
            GameMatch::$round => 'required',
            GameMatch::$tournament_id => 'required|numeric',
            GameMatch::$club1_id => 'required|numeric',
            GameMatch::$club2_id => 'required|numeric',
            GameMatch::$stadium_id => $stadium_id,
        ];

        $validator_results = self::validate($data, $rules);
        if ($validator_results !== true) {
            $error = $validator_results;
            include __DIR__ . '/../view/Error.php';
            return [];
        }


        try {
            $gameMatch = GameMatch::create($data);
            if ($gameMatch) {
                if ($referee_ids) {
                    foreach ($referee_ids as $referee_id) {
                        try {
                            RefereeMatch::create([
                                RefereeMatch::$referee_id => $referee_id,
                                RefereeMatch::$match_id => $gameMatch[GameMatch::$id]
                            ]);
                        } catch (Exception $e) {
                            $error = "Error storing referee match: " . $e->getMessage();
                            include __DIR__ . '/../view/Error.php';
                            return [];
                        }
                    }
                }
                header('Location: GameMatchList.php');
                return [];
            } else {
                $error = "Error storing game match";
                include __DIR__ . '/../view/Error.php';
                return [];
            }
        } catch (Exception $e) {
            $error = "Error storing game match: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
            return [];
        }
    }
}
