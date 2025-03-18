<?php
require_once __DIR__ . '/../model/GameMatch.php';

class GameMatchController
{
    public static function index(): array
    {
        try {
            $gameMatches = GameMatch::getAll();
            return $gameMatches;
        } catch (Exception $e) {
            $error = "Error fetching game matches: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
            return [];
        }
    }

    public static function getGameMatchById($id): array
    {
        try {
            $gameMatch = GameMatch::getById($id);
        } catch (Exception $e) {
            $error = "Error fetching game match: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
            return [];
        }
        if (!$gameMatch) {
            $error = "Game match not found";
            include __DIR__ . '/../view/Error.php';
            return [];
        }

        return $gameMatch;
    }

    public static function getByTournament($tournament_id): array
    {
        if (!$tournament_id) {
            $error = "Invalid tournament id";
            include __DIR__ . '/../view/Error.php';
            return [];
        }

        try {
            $gameMatches = GameMatch::getByFields(GameMatch::$tournament_id, $tournament_id);
        } catch (Exception $e) {
            $error = "Error fetching game matches: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
            return [];
        }
        return $gameMatches;
    }


}
