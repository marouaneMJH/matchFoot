<?php
require_once __DIR__ . '/../helper/UploadFileHelper.php';
require_once __DIR__ . '/../model/Tournament.php';
require_once __DIR__ . '/../model/TournamentAdmin.php';
require_once __DIR__ . '/Controller.php';

class TournamentController extends Controller
{
    private static $uploadDirectory = __DIR__ . '/../../public/uploads/tournament_logo/';
    private static $uploadSubDirectory = 'tournament_logo';

    public static function index(): array
    {
        try {
            $tournaments = Tournament::getAll();
            $modifiedTournament = [];
            if ($tournaments) {
                foreach ($tournaments as $tournament) {
                    $tournament['logo'] = 'http://efoot/logo?file=' . $tournament[Tournament::$logoPath] . '&dir=' . self::$uploadSubDirectory;
                    $modifiedTournament[] = $tournament;
                }
                return $modifiedTournament;
            }
            return [];
        } catch (PDOException $e) {
            $error = "Error fetching clubs: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
            return [];
        }
    }

    public static function getTournamentsByAdminId($adminId): array
    {
        try {
            $tournaments = Tournament::getData(
                [TournamentAdmin::$adminId => $adminId],
                [
                    TournamentAdmin::$table => [
                        'condition' => TournamentAdmin::$tournamentId . ' = ' . Tournament::$table . '.id',
                    ]
                ],
                [
                    'id'
                ]
            );

            if (!$tournaments) {
                $error = "Tournaments not found";
                include __DIR__ . '/../view/Error.php';
                return [];
            }
            foreach ($tournaments as $tournament) {
                $tournament['logo'] = 'http://efoot/logo?file=' . $tournament[Tournament::$logoPath] . '&dir=' . self::$uploadSubDirectory;
            }

            return $tournaments;
        } catch (PDOException $e) {
            $error = "Error fetching tournament: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
            die();
            return [];
        }
    }

    public static function getTournamentById($id): array
    {
        try {
            $tournament = Tournament::getById($id);
            if (!$tournament) {
                $error = "Tournament not found";
                include __DIR__ . '/../view/Error.php';
                return [];
            }
            $tournament['logo'] = 'http://efoot/logo?file=' . $tournament[Tournament::$logoPath] . '&dir=' . self::$uploadSubDirectory;
            return $tournament;
        } catch (Exception $e) {
            $error = "Error fetching tournament: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
            return [];
        }
    }

    public static function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $error = "Invalid request method";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        $name = isset($_POST['name']) ? trim($_POST['name']) : null;
        $teamNbr = isset($_POST['teamNbr']) ? trim(intval($_POST['teamNbr'])) : null;
        $roundNbr = isset($_POST['roundNbr']) ? trim(intval($_POST['roundNbr'])) : null;
        $logo_path = null;

        $data = [
            Tournament::$name => $name,
            Tournament::$teamNbr => $teamNbr,
            Tournament::$roundNbr => $roundNbr
        ];

        $rules = [
            Tournament::$name => 'required',
            Tournament::$teamNbr => 'required|numeric',
            Tournament::$roundNbr => 'required|numeric',
        ];

        $validatpr_results = self::validate($data, $rules);
        if ($validatpr_results !== true) {
            $error = $validatpr_results;
            include __DIR__ . '/../view/Error.php';
            return;
        }

        if (isset($_FILES['logo'])) {
            $logo = $_FILES['logo'];
            $logo_path = uploadImage($logo, self::$uploadDirectory);
            $data[Tournament::$logoPath] = $logo_path;
        }

        try {
            Tournament::create($data);
            header('Location: TournamentList.php');
        } catch (PDOException $e) {
            $error = "Error creating tournament: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
            return;
        }
    }

    public static function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $error = "Invalid request method";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        $id = isset($_POST['id']) ? trim(intval($_POST['id'])) : null;
        $name = isset($_POST['name']) ? trim($_POST['name']) : null;
        $teamNbr = isset($_POST['teamNbr']) ? trim(intval($_POST['teamNbr'])) : null;
        $roundNbr = isset($_POST['roundNbr']) ? trim(intval($_POST['roundNbr'])) : null;
        $logo_path = null;
        $old_logo_path = null;

        $data = [
            Tournament::$id => $id,
            Tournament::$name => $name,
            Tournament::$teamNbr => $teamNbr,
            Tournament::$roundNbr => $roundNbr
        ];

        $rules = [
            Tournament::$id => 'required|numeric',
            Tournament::$name => 'required',
            Tournament::$teamNbr => 'required|numeric',
            Tournament::$roundNbr => 'required|numeric',
        ];

        $validatpr_results = self::validate($data, $rules);
        if ($validatpr_results !== true) {
            $error = $validatpr_results;
            include __DIR__ . '/../view/Error.php';
            return;
        }


        try {
            $tournament = Tournament::getById($id);
            if (!$tournament) {
                $error = "Tournament not found";
                include __DIR__ . '/../view/Error.php';
                return;
            }
        } catch (PDOException $e) {
            $error = "Error fetching tournament: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
            return;
        }

        if (isset($_FILES['logo']) && $_FILES['logo']['size'] > 0) {
            $logo = $_FILES['logo'];
            $old_logo_path = $tournament[Tournament::$logoPath];
            $logo_path = uploadImage($logo, self::$uploadDirectory);
            $data[Tournament::$logoPath] = $logo_path;
        }

        try {
            Tournament::update($id, $data);
            if ($old_logo_path) {
                deleteImage(self::$uploadDirectory . $old_logo_path);
            }
            header('Location: TournamentList.php');
        } catch (PDOException $e) {
            if ($logo_path) {
                deleteImage(self::$uploadDirectory . $logo_path);
            }
            $error = "Error updating tournament: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
            return;
        }
    }

    public static function deleteTournament($id): void
    {
        if (!$id) {
            $error = "Tournament ID is required";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        try {
            $tournament = Tournament::getById($id);
            if (!$tournament) {
                $error = "Tournament not found";
                include __DIR__ . '/../view/Error.php';
                return;
            }

            $logoPath = $tournament[Tournament::$logoPath];
            Tournament::delete($id);

            if ($logoPath) {
                deleteImage(self::$uploadDirectory . $logoPath);
            }
        } catch (Exception $e) {
            $error = "Error deleting tournament: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
            return;
        }
    }

    public static function getStandings($tournament_id): array {
        // Get all necessary data
        $matches = Tournament::getMatchesByTournament($tournament_id);
        $goals = Tournament::getGoalsByTournament($tournament_id);
        $teams = Tournament::getTeamsByTournament($tournament_id);
        
        // Initialize standings array
        $standings = [];
        foreach ($teams as $team) {
            $standings[$team['id']] = [
                'team_id' => $team['id'],
                'name' => $team['name'],
                'logo' => $team['logo_path'] ?  'http://efoot/logo?file=' . $team['logo_path'] . '&dir=club_logo' :"http://efoot/logo?file=img-placeholder.png&dir=image_placeholder" ,
                'matches_played' => 0,
                'wins' => 0,
                'draws' => 0,
                'losses' => 0,
                'goals_for' => 0,
                'goals_against' => 0,
                'goal_difference' => 0,
                'points' => 0
            ];
        }

        // Calculate goals for each match
        $match_goals = [];
        foreach ($goals as $goal) {
            $match_id = $goal['match_id'];
            if (!isset($match_goals[$match_id])) {
                $match_goals[$match_id] = ['home' => 0, 'away' => 0];
            }
            
         
            $match_goals[$match_id][($goal['club_type'] == 'H' ? "home" : "away")]++;
        }

        // Calculate standings
        foreach ($matches as $match) {
            $home_goals = $match_goals[$match['id']]['home'] ?? 0;
            $away_goals = $match_goals[$match['id']]['away'] ?? 0;
            
            // Update home team stats
            $standings[$match['club1_id']]['matches_played']++;
            $standings[$match['club1_id']]['goals_for'] += $home_goals;
            $standings[$match['club1_id']]['goals_against'] += $away_goals;
            
            // Update away team stats
            $standings[$match['club2_id']]['matches_played']++;
            $standings[$match['club2_id']]['goals_for'] += $away_goals;
            $standings[$match['club2_id']]['goals_against'] += $home_goals;
            
            // Determine match result
            if ($home_goals > $away_goals) {
                $standings[$match['club1_id']]['wins']++;
                $standings[$match['club1_id']]['points'] += 3;
                $standings[$match['club2_id']]['losses']++;
            } elseif ($home_goals < $away_goals) {
                $standings[$match['club2_id']]['wins']++;
                $standings[$match['club2_id']]['points'] += 3;
                $standings[$match['club1_id']]['losses']++;
            } else {
                $standings[$match['club1_id']]['draws']++;
                $standings[$match['club2_id']]['draws']++;
                $standings[$match['club1_id']]['points']++;
                $standings[$match['club2_id']]['points']++;
            }
        }

        // Calculate goal difference and sort standings
        foreach ($standings as &$team) {
            $team['goal_difference'] = $team['goals_for'] - $team['goals_against'];
        }

        // Sort by points, goal difference, and goals scored
        usort($standings, function($a, $b) {
            if ($a['points'] !== $b['points']) {
                return $b['points'] - $a['points'];
            }
            if ($a['goal_difference'] !== $b['goal_difference']) {
                return $b['goal_difference'] - $a['goal_difference'];
            }
            return $b['goals_for'] - $a['goals_for'];
        });

        return $standings;
    }

    public static function getLastFiveMatches($team_id): array {
        try {
            $matches = Tournament::getLastFiveMatchesByTeam($team_id);
            $results = [];
            
            foreach ($matches as $match) {
                if ($match['club1_id'] == $team_id) {
                    // Team played at home
                    if ($match['home_goals'] > $match['away_goals']) {
                        $results[] = 'W';
                    } elseif ($match['home_goals'] < $match['away_goals']) {
                        $results[] = 'L';
                    } else {
                        $results[] = 'D';
                    }
                } else {
                    // Team played away
                    if ($match['away_goals'] > $match['home_goals']) {
                        $results[] = 'W';
                    } elseif ($match['away_goals'] < $match['home_goals']) {
                        $results[] = 'L';
                    } else {
                        $results[] = 'D';
                    }
                }
            }
    
            return $results;
        } catch (Exception $e) {
            return ['N', 'N', 'N', 'N', 'N']; // Return placeholder on error
        }
    }
}