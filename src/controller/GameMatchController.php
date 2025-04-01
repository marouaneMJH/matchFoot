<?php
require_once __DIR__ . '/../model/GameMatch.php';

class GameMatchController extends Controller
{

    private static function getMatchStatus($gameMatch): string
    {
        $matchDate = $gameMatch[GameMatch::$date];
        $matchTime = $gameMatch[GameMatch::$time];
        $matchStart = strtotime("$matchDate $matchTime");
        $now = time();
        $elapsed = $now - $matchStart; // in seconds

        if ($matchDate < date('Y-m-d') || ($matchDate == date('Y-m-d') && $matchTime < date('H:i:s') && $elapsed > 120 * 60)) {
            $status = "Finished";
        } elseif ($elapsed >= 0 && $elapsed < 45 * 60) {
            $status = "1st Half";
        } elseif ($elapsed >= 45 * 60 && $elapsed < 60 * 60) {
            $status = "Halftime";
        } elseif ($elapsed >= 60 * 60 && $elapsed < 90 * 60) {
            $status = "2nd Half";
        } elseif ($elapsed >= 90 * 60 && $elapsed < 120 * 60) {
            $status = "Extra Time";
        } elseif ($elapsed < 0) {
            $status = "Upcoming";
        } else {
            $status = "Unknown";
        }
        return $status;
    }
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

    public static function indexByTournament($tournament_id): array
    {
        if (!$tournament_id) {
            $error = "Invalid tournament id";
            include __DIR__ . '/../view/Error.php';
            return [];
        }

        try {
            $gameMatches = GameMatch::getAllMatches($tournament_id);
            $modifiedGameMatches = [];
            if ($gameMatches) {
                foreach ($gameMatches as $gameMatch) {
                    $gameMatch['club1_logo'] = 'http://efoot/logo?file=' . $gameMatch['club1_logo_path'] . '&dir=club_logo';
                    $gameMatch['club2_logo'] = 'http://efoot/logo?file=' . $gameMatch['club2_logo_path'] . '&dir=club_logo';
                    $gameMatch['status'] = self::getMatchStatus($gameMatch);
                    $modifiedGameMatches[] = $gameMatch;
                }
              
                return $modifiedGameMatches;
            } else {
                return [];
            }
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
        $tournament_id = isset($_POST['tournamentId']) ? $_POST['tournamentId'] : null;
        $club1_id = isset($_POST['club1_id']) ? $_POST['club1_id'] : null;
        $club2_id = isset($_POST['club2_id']) ? $_POST['club2_id'] : null;
        $referee_ids = isset($_POST['referee_id']) ? $_POST['referee_id'] : null;
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
                header('Location: TournamentInfos.php');
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

    public static function update(): array
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $error = "Invalid request method";
            include __DIR__ . '/../view/Error.php';
            return [];
        }
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $date = isset($_POST['date']) ? $_POST['date'] : null;
        $time = isset($_POST['time']) ? $_POST['time'] : null;
        $round = isset($_POST['round']) ? $_POST['round'] : null;
        $tournament_id = isset($_POST['tournamentId']) ? $_POST['tournamentId'] : null;
        $club1_id = isset($_POST['club1_id']) ? $_POST['club1_id'] : null;
        $club2_id = isset($_POST['club2_id']) ? $_POST['club2_id'] : null;
        $referee_ids = isset($_POST['referee_id']) ? $_POST['referee_id[]'] : null;
        $stadium_id = isset($_POST['stadium_id']) ? $_POST['stadium_id'] : null;

        $data = [
            GameMatch::$id => $id,
            GameMatch::$date => $date,
            GameMatch::$time => $time,
            GameMatch::$round => $round,
            GameMatch::$tournament_id => $tournament_id,
            GameMatch::$club1_id => $club1_id,
            GameMatch::$club2_id => $club2_id,
            GameMatch::$stadium_id => $stadium_id,
        ];

        $rules = [
            GameMatch::$id => 'required|numeric',
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
            $gameMatch = GameMatch::update($id, $data);
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
                $error = "Error updating game match";
                include __DIR__ . '/../view/Error.php';
                return [];
            }
        } catch (Exception $e) {
            $error = "Error updating game match: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
            return [];
        }
    }

    public static function delete($id): array
    {
        if (!$id) {
            $error = "Invalid game match id";
            include __DIR__ . '/../view/Error.php';
            return [];
        }

        try {
            $gameMatch = GameMatch::delete($id);
            if ($gameMatch) {
                header('Location: GameMatchList.php');
                return [];
            } else {
                $error = "Error deleting game match";
                include __DIR__ . '/../view/Error.php';
                return [];
            }
        } catch (Exception $e) {
            $error = "Error deleting game match: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
            return [];
        }
    }
}
