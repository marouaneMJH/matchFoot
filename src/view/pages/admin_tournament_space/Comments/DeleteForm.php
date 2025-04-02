<?php
require_once __DIR__ . '/../../../../controller/NewsController.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    var_dump($id);
    NewsController::deleteNews($id);
    
}