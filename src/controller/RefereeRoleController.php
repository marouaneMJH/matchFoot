<?php
require_once __DIR__ . '/../model/RefereeRole.php';
require_once __DIR__ . '/Controller.php';
class RefereeRoleController extends Controller
{
    public static function index():array
    {
        $referees = RefereeRole::getAll();
        if (!$referees) {
            $error = "No referees found";
            include __DIR__ . '/../view/Error.php';
            return [];
        }

        return $referees;

        
       
    }
}