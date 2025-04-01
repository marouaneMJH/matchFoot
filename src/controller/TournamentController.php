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
}
