<?php
include_once "./components/MailComponent.php";
include_once "../../../controller/AuthController.php";

echo '<link rel="stylesheet" href="../../styles/output.css">';
$mainPage = new SimpleMailPage(AuthController::getUserId());

echo $mainPage->render();
?>