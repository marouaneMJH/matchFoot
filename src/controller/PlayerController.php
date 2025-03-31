<?php
require_once __DIR__ . '/../model/Player.php';
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/ClubController.php';
require_once __DIR__ . '/PositionController.php';
require_once __DIR__ . '/CountryController.php';
require_once __DIR__ . '/../helper/UploadFileHelper.php';
class PlayerController extends Controller
{

    private static $uploadDirectory = __DIR__ . '/../../public/uploads/player_profiles/';
    private static $uploadSubDirectory = 'player_profiles';

    public static function index(): array
    {
        try {
            $players = Player::getAll();
            $modifiedPlayers = [];
            if ($players) {
                foreach ($players as $player) {
                    $club = ClubController::getClubById($player[Player::$clubId]);
                    $position = PositionController::getPositionById($player[Player::$positionId]);
                    $country= CountryController::getCountryById($player[Player::$countryId]);
                    
                    $player['profile'] = "http://efoot/logo?file=" . $player[Player::$profilePath] . "&dir=" . self::$uploadSubDirectory;
                    $player['position'] = $position;
                    $player['club'] = $club;
                    $player['country'] = $country;
                    $modifiedPlayers[] = $player;
                }

                return $modifiedPlayers;
            }
            return [];
        } catch (Exception $e) {
            $error = "Error fetching players: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
            return [];
        }
    }

    public static function getPlayerById($id): array
    {
        try {
            $player = Player::getById($id);
            if (!$player) {
                $error = "Player not found";
                include __DIR__ . '/../view/Error.php';
                return [];
            }

            $club = ClubController::getClubById($player[Player::$clubId]);
            $position = PositionController::getPositionById($player[Player::$positionId]);
            $country= CountryController::getCountryById($player[Player::$countryId]);

            $player['profile'] = "http://efoot/logo?file=" . $player[Player::$profilePath] . "&dir=" . self::$uploadSubDirectory;
            $player['club'] = $club;
            $player['position'] = $position;
            $player['country'] = $country;
            return $player;
        } catch (Exception $e) {
            $error = "Error fetching player: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
            return [];
        }
    }

    public static function getPlayersByClub($club_id){
        if(!$club_id) {
            $error = "Club ID is required";
            include __DIR__ . '/../view/Error.php';
            return [];
        }

        try {
            $players = Player::getData([Player::$clubId => $club_id]);
            if (!$players) {
                $error = "Players not found";
                include __DIR__ . '/../view/Error.php';
                return [];
            }
            foreach ($players as $player) {
                $player['profile'] = "http://efoot/logo?file=" . $player[Player::$profilePath] . "&dir=" . self::$uploadSubDirectory;
            }
            return $players;
        } catch (Exception $e) {
            $error = "Error fetching players: " . $e->getMessage();
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

        $firstName = isset($_POST['first_name']) ? trim($_POST['first_name']) : null;
        $lastName = isset($_POST['last_name']) ? trim($_POST['last_name']) : null;
        $birthDate = isset($_POST['birth_date']) ? trim($_POST['birth_date']) : null;
        $weight = isset($_POST['weight']) ? trim($_POST['weight']) : null;
        $height = isset($_POST['height']) ? trim($_POST['height']) : null;
        $foot = isset($_POST['foot']) ? trim($_POST['foot']) : null;
        $country_id = isset($_POST['country']) ? trim(intval($_POST['country'])) : null;
        $position_id = isset($_POST['position']) ? trim(intval($_POST['position'])) : null;
        $club_id = isset($_POST['club']) ? trim(intval($_POST['club'])) : null;
        $profile_path = null;

        $data = [
            Player::$firstName => $firstName,
            Player::$lastName => $lastName,
            Player::$birthDate => $birthDate,
            Player::$weight => $weight,
            Player::$height => $height,
            Player::$foot => $foot,
            Player::$countryId => $country_id,
            Player::$positionId => $position_id,
            Player::$clubId => $club_id,
        ];

        $rules = [
            Player::$firstName => 'required|min:2|max:30',
            Player::$lastName => 'required|min:2|max:30',
            Player::$birthDate => 'required|date_format:Y-m-d',
            Player::$weight => 'required|numeric|min:0',
            Player::$height => 'required|numeric|min:0',
            Player::$foot => 'required|in:R,L,B',
            Player::$countryId => 'required|numeric',
            Player::$positionId => 'required|numeric',
            Player::$clubId => 'required|numeric',
        ];

        $validator_result = self::validate($data, $rules);

        if ($validator_result !== true) {
            $error = $validator_result;
            include __DIR__ . '/../view/Error.php';
            return;
        }

        if (isset($_FILES['profile'])) {
            $file = $_FILES['profile'];
            $profile_path = uploadImage($file, self::$uploadDirectory);
        }

        $data[Player::$profilePath] = $profile_path;

        try {
            if (!$country_id || !Country::exists([Country::$id => $country_id])) {
                $error = "Country not found";
                include __DIR__ . '/../view/Error.php';
                return;
            }
            if (!$position_id || !Position::exists([Position::$id => $position_id])) {
                $error = "Position not found";
                include __DIR__ . '/../view/Error.php';
                return;
            }
            if (!$club_id || !Club::exists([Club::$id => $club_id])) {
                $error = "Club not found";
                include __DIR__ . '/../view/Error.php';
                return;
            }
        } catch (Exception $e) {
            $error = "Error fetching: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
            return;
        }

        try {
            Player::create($data);
            header("Location: PlayerList.php");
        } catch (Exception $e) {
            $error = "Error creating player: " . $e->getMessage();
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
        $firstName = isset($_POST['first_name']) ? trim($_POST['first_name']) : null;
        $lastName = isset($_POST['last_name']) ? trim($_POST['last_name']) : null;
        $birthDate = isset($_POST['birth_date']) ? trim($_POST['birth_date']) : null;
        $weight = isset($_POST['weight']) ? trim($_POST['weight']) : null;
        $height = isset($_POST['height']) ? trim($_POST['height']) : null;
        $foot = isset($_POST['foot']) ? trim($_POST['foot']) : null;
        $country_id = isset($_POST['country']) ? trim(intval($_POST['country'])) : null;
        $position_id = isset($_POST['position']) ? trim(intval($_POST['position'])) : null;
        $club_id = isset($_POST['club']) ? trim(intval($_POST['club'])) : null;
        $profile_path = null;
        $old_profile_path = null;

        $data = [
            Player::$firstName => $firstName,
            Player::$lastName => $lastName,
            Player::$birthDate => $birthDate,
            Player::$weight => $weight,
            Player::$height => $height,
            Player::$foot => $foot,
            Player::$countryId => $country_id,
            Player::$positionId => $position_id,
            Player::$clubId => $club_id,
        ];

        $rules = [
            Player::$firstName => 'required|min:2|max:30',
            Player::$lastName => 'required|min:2|max:30',
            Player::$birthDate => 'required|date_format:Y-m-d',
            Player::$weight => 'required|numeric|min:0',
            Player::$height => 'required|numeric|min:0',
            Player::$foot => 'required|in:R,L,B',
            Player::$countryId => 'required|numeric',
            Player::$positionId => 'required|numeric',
            Player::$clubId => 'required|numeric',
        ];

        $validator_result = self::validate($data, $rules);

        if ($validator_result !== true) {
            $error = $validator_result;
            include __DIR__ . '/../view/Error.php';
            return;
        }

        if (isset($_FILES['profile'])) {
            $file = $_FILES['profile'];
            $profile_path = uploadImage($file, self::$uploadDirectory);
            $old_profile_path = isset($_POST['old_profile_path']) ? trim($_POST['old_profile_path']) : null;
        }

        $data[Player::$profilePath] = $profile_path;

        try {
            if (!$country_id || !Country::exists([Country::$id => $country_id])) {
                $error = "Country not found";
                include __DIR__ . '/../view/Error.php';
                return;
            }
            if (!$position_id || !Position::exists([Position::$id => $position_id])) {
                $error = "Position not found";
                include __DIR__ . '/../view/Error.php';
                return;
            }
            if (!$club_id || !Club::exists([Club::$id => $club_id])) {
                $error = "Club not found";
                include __DIR__ . '/../view/Error.php';
                return;
            }
        } catch (Exception $e) {
            $error = "Error fetching: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
            return;
        }

        try {
            Player::update($id, $data);
            if ($old_profile_path) {
                deleteImage(self::$uploadDirectory . $old_profile_path);
            }
            header("Location: PlayerList.php");
        }catch (Exception $e) {
            if($old_profile_path) {
                deleteImage(self::$uploadDirectory . $profile_path);
            }
            $error = "Error updating player: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
        }
    }

    public static function deletePlayer($id): void
    {
        if (!$id) {
            $error = "Player ID is required";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        try {
            $player = Player::getById($id);
            if (!$player) {
                $error = "Player not found";
                include __DIR__ . '/../view/Error.php';
                return;
            }
            $profile_path = $player[Player::$profilePath];
            Player::delete($id);

            if ($profile_path) {
                deleteImage(self::$uploadDirectory . $profile_path);
            }
            header("Location: PlayerList.php");
        } catch (Exception $e) {
            $error = "Error deleting player: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
        }
    }
}
