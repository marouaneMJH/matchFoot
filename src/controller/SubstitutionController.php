<?php
require_once __DIR__ . '/../model/Substitution.php';
require_once __DIR__ . '/Controller.php';

class SubstitutionController extends Controller
{
    public static function index(): array
    {
        $substitutions = Substitution::getAll();

        if (!$substitutions) {
            $error = "No substitutions found";
            include __DIR__ . '/../view/Error.php';
            return [];
        }

        return $substitutions;
    }

    
        public static function getSubstitutionsByMatchId($matchId): array
        {
            $substitutions = Substitution::getByMatchID($matchId);
            if (!$substitutions) {
                // $error = "No substitutions found for this match";
                // include __DIR__ . '/../view/Error.php';
                return [];
            }
    
            return $substitutions;
        }

    public static function store(): void{
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            $error = "Invalid request method";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        $lineup1Id = $_POST['lineup_1_id'] ?? null;
        $lineup2Id = $_POST['lineup_2_id'] ?? null;
        $minute = intval($_POST['minute']) ?? null;

        $data = [
            Substitution::$lineup1_id => $lineup1Id,
            Substitution::$lineup2_id => $lineup2Id,
            Substitution::$minute => $minute
        ];

        $rules = [
            Substitution::$lineup1_id => 'required|numeric',
            Substitution::$lineup2_id => 'required|numeric',
            Substitution::$minute => 'numeric'
        ];

        $validator_result = self::validate($data, $rules);
        if ($validator_result !== true) {
            $error = "Validation error: " . implode(", ", $validator_result);
            include __DIR__ . '/../view/Error.php';
            return;
        }

        try {
            Substitution::create($data);
           return;
        } catch (Exception $e) {
            $error = "Error creating substitution: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
            return;
        }
    }

    public static function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $error = "Invalid request method";
            include __DIR__ . '/../view/Error.php';
            return;
        }
        $id = $_POST['event_id'] ?? null;
        $lineup1Id = $_POST['lineup_1_id'] ?? null;
        $lineup2Id = $_POST['lineup_2_id'] ?? null;
        $minute = intval($_POST['minute']) ?? null;

        $data = [
            Substitution::$lineup1_id => $lineup1Id,
            Substitution::$lineup2_id => $lineup2Id,
            Substitution::$minute => $minute
        ];

        $rules = [
            Substitution::$lineup1_id => 'required|numeric',
            Substitution::$lineup2_id => 'required|numeric',
            Substitution::$minute => 'numeric'
        ];

        $validator_result = self::validate($data, $rules);
        if ($validator_result !== true) {
            $error = "Validation error: " . implode(", ", $validator_result);
            include __DIR__ . '/../view/Error.php';
            return;
        }

        if (Substitution::update($id, $data)) {
            return;
        } else {
            $error = "Error updating substitution";
            include __DIR__ . '/../view/Error.php';
            return;
        }
    }

    public static function delete($id): void
    {
        if ($_SERVER['REQUEST_METHOD'] != 'DELETE') {
            $error = "Invalid request method";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        if (Substitution::delete($id)) {
            return;
        } else {
            $error = "Error deleting substitution";
            include __DIR__ . '/../view/Error.php';
            return;
        }
    }

}