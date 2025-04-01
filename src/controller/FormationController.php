<?php 
require_once __DIR__ . '/../model/Formation.php';
require_once __DIR__ . '/Controller.php';

class FormationController extends Controller
{
    public static function index(): array
    {
        $formations = Formation::getAll();
        if ($formations) {
            return $formations;
        } else {
            return [];
        }
    }

}