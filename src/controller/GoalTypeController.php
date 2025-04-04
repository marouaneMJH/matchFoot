<?php
require_once __DIR__ . '/../model/GoalType.php';
require_once __DIR__ . '/Controller.php';

class GoalTypeController extends Controller {

    public static function index():array{
        $goalTypes = GoalType::getAll();

        if (!$goalTypes) {
            $error = "No goal types found";
            include __DIR__ . '/../view/Error.php';
            return [];
        }
        
        return $goalTypes;
    }
}