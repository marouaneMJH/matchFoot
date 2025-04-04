<?php
require_once __DIR__ . '/../../../controller/PlayerController.php';
if (isset($_GET['id'])) {
    // Appeler la méthode qui va récupérer et afficher les détails du joueur
    PlayerController::showPlayerDetail($_GET['id']);
} else {
    echo "<div class='p-4 text-red-500'>Aucun joueur spécifié</div>";
}
?>