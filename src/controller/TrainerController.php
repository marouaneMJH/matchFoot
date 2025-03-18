<?php
require_once __DIR__ . '/StaffController.php';

class TrainerController extends StaffController{


    public static function index(): array
    {
        try {
            $trainers = Staff::getByFields([Staff::$role_id => '1']);
            if ($trainers) {
                return $trainers;
            } else {
                return [];
            }
        } catch (Exception $e) {
            $error = "Error fetching trainers: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
            return [];
        }
    }
}