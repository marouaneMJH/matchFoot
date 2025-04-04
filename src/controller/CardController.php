<?php
require_once __DIR__ . '/../model/Card.php';
require_once __DIR__ . '/Controller.php';

class CardController extends Controller
{

    public static function index(): array
    {
        $cards = Card::getAll();

        if (!$cards) {
            $error = "No cards found";
            include __DIR__ . '/../view/Error.php';
            return [];
        }

        return $cards;
    }

    public static function getCardsByMatchId($matchId): array
    {
        $cards = Card::getByMatchID($matchId);
        if (!$cards) {
            // $error = "No cards found for this match";
            // include __DIR__ . '/../view/Error.php';
            return [];
        }

        return $cards;
    }

    public static function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $error = "Invalid request method";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        $lineupId = $_POST['lineup_id'] ?? null;
        $minute = intval($_POST['minute']) ?? null;
        $typeId = $_POST['card_type'] ?? null;

        $data = [
            Card::$lineup_id => $lineupId,
            Card::$minute => $minute,
            Card::$type => $typeId
        ];
        // var_dump($data);
        // die();

        $rules = [
            Card::$lineup_id => 'required|numeric',
            Card::$minute => 'numeric',
            Card::$type => 'required'
        ];

        $validator_result = self::validate($data, $rules);
        if ($validator_result !== true) {
            include __DIR__ . '/../view/Error.php';
            return;
        }

        if (Card::create($data)) {

            return;
        } else {

            $error = "Failed to create card";
            include __DIR__ . '/../view/Error.php';
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
        $lineupId = $_POST['lineup_id'] ?? null;
        $minute = intval($_POST['minute']) ?? null;
        $typeId = $_POST['card_type'] ?? null;

        $data = [
            Card::$lineup_id => $lineupId,
            Card::$minute => $minute,
            Card::$type => $typeId
        ];

        $rules = [
            Card::$lineup_id => 'required|numeric',
            Card::$minute => 'numeric',
            Card::$type => 'required'
        ];

        $validator_result = self::validate($data, $rules);
        if ($validator_result !== true) {
            include __DIR__ . '/../view/Error.php';
            return;
        }

        if (Card::update($id, $data)) {
            return;
        } else {
            $error = "Failed to update card";
            include __DIR__ . '/../view/Error.php';
        }
    }

    public static function delete($id): void
    {
        if ($_SERVER['REQUEST_METHOD'] != 'DELETE') {
            $error = "Invalid request method";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        if (Card::delete($id)) {
           return;
        } else {
            $error = "Failed to delete card";
            include __DIR__ . '/../view/Error.php';
        }
    }
}
