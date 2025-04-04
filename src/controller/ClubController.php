<?php
require_once __DIR__ . '/../helper/UploadFileHelper.php';
require_once __DIR__ . '/../model/Club.php';
require_once __DIR__ . '/../model/Player.php';
require_once __DIR__ . '/StadiumController.php';
require_once __DIR__ . '/StaffController.php';
require_once __DIR__ . '/TrainerController.php';
require_once __DIR__ . '/Controller.php';

require_once "AuthController.php";

class ClubController extends Controller
{
    private static $uploadDirectory = __DIR__ . '/../../public/uploads/club_logo/';
    private static $uploadSubDirectory = 'club_logo';

    public static function index(): array
    {
        try {
        //    $clubs = Club::getAll();
            $clubs = Club::getData(
                [],
                [Stadium::$table => ['condition' => Club::$stadium_id .'='. Stadium::$table . '.' . Stadium::$id]],
                ['id','name']
            );
            
            $modifiedClubs = [];
            if ($clubs) {
                foreach ($clubs as $club) {
                    // $stade = StadiumController::getStadById($club[Club::$stadium_id]);
                    if($club[Club::$logo_path])
                        $club['logo'] = 'http://efoot/logo?file=' . $club[Club::$logo_path] . '&dir=' . self::$uploadSubDirectory;
                    // $club['stadium'] = $stade;
                    $club['trainer'] = null;
                    $modifiedClubs[] = $club;
                }

                return $modifiedClubs;
               
            } else {
                return [];
            }
        } catch (Exception $e) {
            $error = "Error fetching clubs: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
            return [];
        }
    }
    
    public static function getClubById($id): array
    {
        $club = Club::getById($id);
        if (!$club) {
            $error = "Club not found";
            include __DIR__ . '/../view/Error.php';
            return [];
        }
    
        $stadium = Stadium::getById($club[Club::$stadium_id]);
        
        // Récupérer la ville du stade
        if ($stadium && isset($stadium['city_id'])) {
            $ville = City::getById($stadium['city_id']);
            if ($ville) {
                $stadium['ville'] = $ville;
            }
        }
        
        $trainer = null; // ou récupérer l'entraîneur si nécessaire
    
        $club['logo'] = 'http://efoot/logo?file=' . $club[Club::$logo_path] . '&dir=' . self::$uploadSubDirectory;
        $club['stadium'] = $stadium;
        $club['trainer'] = $trainer;
    
        return $club;
    }

    public static function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $error = "Invalid request method";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        $name = isset($_POST['name']) ? trim($_POST['name']) : null;
        $nickname = isset($_POST['nickname']) ? trim($_POST['nickname']) : null;
        $founded_at = isset($_POST['founded_at']) ? trim(intval($_POST['founded_at'])) : null;
        $stade_id = isset($_POST['stade_id']) ? trim($_POST['stade_id']) : null;
        $trainer_id = isset($_POST['trainer_id']) ? trim(intval($_POST['trainer_id'])) : null;
        $logo_path = null;


        $data = [
            Club::$name => $name,
            Club::$nickname => $nickname,
            Club::$founded_at => $founded_at,
            Club::$stadium_id => $stade_id,
            Club::$trainer_id => $trainer_id
        ];

        $rules = [
            Club::$name => 'required',
            Club::$nickname => 'required|max:5',
            Club::$founded_at => 'required|numeric|max:4|min:4',
            Club::$stadium_id => 'required|numeric',
            Club::$trainer_id => 'numeric'
        ];

        $validate_result = self::validate($data, $rules);
        //  echo $validate_result;
        if ($validate_result !== true) {
            $error = $validate_result;
            include __DIR__ . '/../view/Error.php';
            return;
        }

        // Handle file upload
        if (isset($_FILES["logo"])) {

            $logo = $_FILES["logo"];
            $logo_path = uploadImage($logo, self::$uploadDirectory);
        }

        $created_at = date('Y-m-d H:i:s');
        try {
            if (!$stade_id || !Stadium::exists([Club::$id => $stade_id])) {
                $error = "Stadium not found";
                include __DIR__ . '/../view/Error.php';
                return;
            }
        } catch (Exception $e) {
            $error = "Error fetching stadiums: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
            return;
        }

        $data[Club::$logo_path] = $logo_path;
        $data[Club::$created_at] = $created_at;
        try {

            Club::create($data);


            header("Location: ClubList.php?success=1");
            // exit();
        } catch (Exception $e) {
            if ($logo_path) {
                deleteImage(self::$uploadDirectory . $logo_path);
            }
            $error = "Failed to create club: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
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
        $nickname = isset($_POST['nickname']) ? trim($_POST['nickname']) : null;
        $founded_at = isset($_POST['founded_at']) ? trim(intval($_POST['founded_at'])) : null;
        $stade_id = isset($_POST['stade_id']) ? trim($_POST['stade_id']) : null;
        $trainer_id = isset($_POST['trainer_id']) ? trim(intval($_POST['trainer_id'])) : null;
        $logo_path = null;
        $old_logo_path = null;

        if (!$id) {
            $error = "Id is required";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        $club = Club::getById($id);
        if (!$club) {
            $error = "Club not found";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        $data = [
            Club::$name => $name,
            Club::$nickname => $nickname,
            Club::$founded_at => $founded_at,
            Club::$stadium_id => $stade_id,
            Club::$trainer_id => $trainer_id
        ];

        $rules = [
            Club::$name => 'required',
            Club::$nickname => 'required|max:5',
            Club::$founded_at => 'required|numeric|max:4|min:4',
            Club::$stadium_id => 'required|numeric',
            Club::$trainer_id => 'numeric'
        ];

        $validate_result = self::validate($data, $rules);

        if ($validate_result !== true) {
            $error = $validate_result;
            include __DIR__ . '/../view/Error.php';
            return;
        }

        $logo_path = $club[Club::$logo_path];

        // Handle file upload
        if (isset($_FILES["logo"]) && $_FILES["logo"]["size"] > 0) {
            $logo = $_FILES["logo"];
            $old_logo_path = $logo_path;
            $logo_path = uploadImage($logo, self::$uploadDirectory);
        }

        try {
            if (!$stade_id || !Stadium::exists([Stadium::$id => $stade_id])) {
                $error = "Stadium not found";
                include __DIR__ . '/../view/Error.php';
                return;
            }
        } catch (Exception $e) {
            $error = "Error fetching stadiums: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
            return;
        }

        $data[Club::$logo_path] = $logo_path;
        $data[Club::$created_at] = $club[Club::$created_at];
        try {

            $result = Club::update($id, $data);

            if ($result) {

                // Delete old logo if new logo is uploaded
                if ($old_logo_path) {
                    deleteImage(self::$uploadDirectory . $old_logo_path);
                }

                header("Location: ClubList.php?updated=1");
                exit();
            } else {

                // Delete new logo if update failed
                if ($old_logo_path) {
                    deleteImage(self::$uploadDirectory . $logo_path);
                }
                $error = "Club not found or already updated";
                include __DIR__ . '/../view/Error.php';
            }
        } catch (Exception $e) {
            $error = "Error updating club: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
        }
    }

    public static function deleteClub($id): void
    {
        if (!$id) {
            $error = "Club ID is required";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        try {
            $club = Club::getById($id);
            if (!$club) {
                $error = "Club not found";
                include __DIR__ . '/../view/Error.php';
                return;
            }
            $logo_path = $club[Club::$logo_path];
            Club::delete($id);

            if ($logo_path) {
                deleteImage(self::$uploadDirectory . $logo_path);
            }
            header("Location: ClubList.php?deleted=1");
        } catch (Exception $e) {
            $error = "Error deleting club: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
        }
    }


    public static function subscribe()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $error = "Invalid request method";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        $userId = $_SESSION['user_id'] ?? null;
        $clubId = $_POST['club_id'] ?? null;

        if (!$userId || !$clubId) {
            $error = "User ID and Club ID are required";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        try {
            if (Club::subscribeByUserId($userId)) {
                // rederect last view 
                AuthController::redirectLastVisitedPage();
                exit();
            } else {
                $error = "Failed to subscribe to club";
                include __DIR__ . '/../view/Error.php';
            }
        } catch (Exception $e) {
            $error = "Error subscribing to club: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
        }
    }

    // Add this method to your ClubController class

public static function unsubscribe()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $error = "Invalid request method";
        include __DIR__ . '/../view/Error.php';
        return;
    }

    $userId = $_SESSION['user_id'] ?? null;
    $clubId = $_POST['club_id'] ?? null;

    if (!$userId || !$clubId) {
        $error = "User ID and Club ID are required";
        include __DIR__ . '/../view/Error.php';
        return;
    }

    try {
        if (Club::unsubscribeByUserId($userId)) {
            // redirect to last viewed page
            AuthController::redirectLastVisitedPage();
            exit();
        } else {
            $error = "Failed to unsubscribe from club";
            include __DIR__ . '/../view/Error.php';
        }
    } catch (Exception $e) {
        $error = "Error unsubscribing from club: " . $e->getMessage();
        include __DIR__ . '/../view/Error.php';
    }
}
    public static function showClubDetail($clubId)
{
    try {
        // Récupérer les données du club
        $club = self::getClubById($clubId);
        if (empty($club)) {
            throw new Exception("Club non trouvé");
        }

        // Récupérer les joueurs du club
        $players = Player::getByFields([Player::$clubId => $clubId]);

        // Inclure la vue - MODIFIEZ CETTE LIGNE POUR POINTER VERS LE BON FICHIER
        include __DIR__ . '/../view/pages/user_space/ClubDetail.php';
    } catch (Exception $e) {
        $error = $e->getMessage();
        include __DIR__ . '/../view/Error.php';
    }
}

    /**
     * Calcule l'âge à partir de la date de naissance
     */
    public static function calculateAge($birthDate)
    {
        if (empty($birthDate)) return 'Inconnu';
        
        $birthDate = new DateTime($birthDate);
        $today = new DateTime();
        return $today->diff($birthDate)->y;
    }

    /**
     * Récupère les prochains matchs du club
     */
    public static function getUpcomingMatches($clubId)
    {
        $query = "SELECT m.*, 
                 home.name as home_team_name, home.logo_path as home_logo,
                 away.name as away_team_name, away.logo_path as away_logo,
                 s.name as stadium_name
                 FROM game_match m
                 JOIN club home ON m.club1_id = home.id
                 JOIN club away ON m.club2_id = away.id
                 JOIN stadium s ON m.stadium_id = s.id
                 WHERE (m.club1_id = :club_id OR m.club2_id = :club_id)
                 AND m.date >= NOW()
                 ORDER BY m.date ASC
                 LIMIT 5";
        
        $pdo = Model::connect();
        $stmt = $pdo->prepare($query);
        $stmt->execute(['club_id' => $clubId]);
        $matches = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Formater les URLs des logos
        foreach ($matches as &$match) {
            $match['home_logo_url'] = "http://efoot/logo?file=" . $match['home_logo'] . "&dir=club_logo";
            $match['away_logo_url'] = "http://efoot/logo?file=" . $match['away_logo'] . "&dir=club_logo";
        }

        return $matches;
    }
}