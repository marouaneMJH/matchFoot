<?php
require_once __DIR__ . '/../../../controller/GoalController.php';
require_once __DIR__ . '/../../../controller/CardController.php';
require_once __DIR__ . '/../../../controller/SubstitutionController.php';
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Read the raw input stream
    $data = json_decode(file_get_contents("php://input"), true);

    $eventId = $data['event_id'] ?? null;
    $eventType = $data['event_type'] ?? null;

    if($eventType == 'G'){
        GoalController::delete($eventId);
        echo json_encode(['status' => 'success', 'message' => 'Goal deleted successfully']);
    }else if($eventType == 'C'){
        CardController::delete($eventId);
        echo json_encode(['status' => 'success', 'message' => 'Card deleted successfully']);
    }else if($eventType == 'S'){
        SubstitutionController::delete($eventId);
        echo json_encode(['status' => 'success', 'message' => 'Substitution deleted successfully']);
    }
   
}
?>