<?php
require_once __DIR__ . '/../../../controller/ClubController.php';
if (isset($_GET['id'])) {
    ClubController::showClubDetail($_GET['id']);
} else {
    echo "<div class='p-4 text-red-500'>Aucun club spécifié</div>";
}
?>