<?php
include_once "./components/MailComponent.php";

echo '<link rel="stylesheet" href="../../styles/output.css">';
$mainPage = new SimpleMailPage(4);

echo $mainPage->render();
?>