<?php
require_once __DIR__ . '/../model/Goal.php';
require_once __DIR__ . '/../model/Lineup.php';
require_once __DIR__ . '/../model/GoalType.php';
require_once __DIR__ . '/Controller.php';

class GoalController extends Controller {

    public static function index():array{
        $goals = Goal::getAll();

        if (!$goals) {
            $error = "No goals found";
            include __DIR__ . '/../view/Error.php';
            return [];
        }
        
        return $goals;
    }

    public static function getGoalsByMatchId($matchId):array{
        $goals = Goal::getByMatchID($matchId);
        if (!$goals) {
            // $error = "No goals found for this match";
            // include __DIR__ . '/../view/Error.php';
            return [];
        }

        return $goals;
    }

    public static function store():void{
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            $error = "Invalid request method";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        $lineupId = $_POST['lineup_id'] ?? null;
        $minute = intval($_POST['minute']) ?? null;
        // var_dump($minute);
        // die();
        $typeId = $_POST['goal_type'] ?? null;
        $assistorId = $_POST['assistor_id'] ?? null;

       $data = [
            Goal::$lineup_id => $lineupId,
            Goal::$minute => $minute,
            Goal::$type_id => $typeId,
            Goal::$assistor_id => $assistorId
        ];

        $rules = [
            Goal::$lineup_id => 'required|numeric',
            Goal::$minute => 'numeric',
            Goal::$type_id => 'required|numeric',
            Goal::$assistor_id => 'numeric'
        ];

        $validator_result = self::validate($data, $rules);
        if($validator_result !== true){
            $error = $validator_result;
            include __DIR__ . '/../view/Error.php';
            return;
        }



        if(Lineup::exists([Lineup::$id => $lineupId]) == false){
            $error = "Lineup not found";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        if(GoalType::exists([GoalType::$id => $typeId]) == false){
            $error = "Goal type not found";
            include __DIR__ . '/../view/Error.php';
            return;
        }
        if($assistorId && Lineup::exists([Lineup::$id => $assistorId]) == false){
            $error = "Assistor not found";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        if($minute < 0 || $minute > 90){
            $error = "Invalid minute value";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        try {
            Goal::create($data);
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            return;
        } catch (Exception $e) {
            $error = "Failed to create goal: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
        }



    
    }

    public static function update():void{
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            $error = "Invalid request method";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        $goalId = $_POST['event_id'] ?? null;
        $lineupId = $_POST['lineup_id'] ?? null;
        $minute = intval($_POST['minute']) ?? null;
        $typeId = $_POST['goal_type'] ?? null;
        $assistorId = $_POST['assistor_id'] ?? null;

       $data = [
            Goal::$id => $goalId,
            Goal::$lineup_id => $lineupId,
            Goal::$minute => $minute,
            Goal::$type_id => $typeId,
            Goal::$assistor_id => $assistorId
        ];

        $rules = [
            Goal::$id => 'required|numeric',
            Goal::$lineup_id => 'required|numeric',
            Goal::$minute => 'numeric',
            Goal::$type_id => 'required|numeric',
            Goal::$assistor_id => 'numeric'
        ];

        $validator_result = self::validate($data, $rules);
        if($validator_result !== true){
            $error = $validator_result;
            include __DIR__ . '/../view/Error.php';
            return;
        }



        if(Goal::exists([Goal::$id => $goalId]) == false){
            $error = "Goal not found";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        if(Lineup::exists([Lineup::$id => $lineupId]) == false){
            $error = "Lineup not found";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        if(GoalType::exists([GoalType::$id => $typeId]) == false){
            $error = "Goal type not found";
            include __DIR__ . '/../view/Error.php';
            return;
        }
        if($assistorId && Lineup::exists([Lineup::$id => $assistorId]) == false){
            $error = "Assistor not found";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        if($minute < 0 || $minute > 90){
            $error = "Invalid minute value";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        try {
            Goal::update($goalId,$data);
            return;
        } catch (Exception $e) {
            $error = "Failed to update goal: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
        }
    }

    public static function delete($goalId):void{
        if($_SERVER['REQUEST_METHOD'] != 'DELETE'){
            $error = "Invalid request method";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        if(Goal::exists([Goal::$id => $goalId]) == false){
            $error = "Goal not found";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        try {
            Goal::delete($goalId);
            return;
        } catch (Exception $e) {
            $error = "Failed to delete goal: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
        }
    }
            

}