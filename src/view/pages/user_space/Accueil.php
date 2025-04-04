<?php
session_start();
$_SESSION["user_id"] = 1;
var_dump($_SESSION["user_id"]);
if (isset($_GET["Target"])) {
  $_SESSION["current_page"] = $_GET["Target"];
}

if (!isset($_SESSION["current_page"])) {
  $_SESSION["current_page"] = "accueil";
}

include_once './components/HeaderNavBar.php';
include_once './components/Sidebar.php';

$header = new HeaderNavBar('../../');
$sidebar = new Sidebar('../../');


?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SoftFootball</title>
  <!-- <script src="https://cdn.tailwindcss.com"></script> -->
  <link rel="stylesheet" href="../../styles/accueil.css" />
  <link rel="stylesheet" href="./../../styles//output.css" />


  <!-- href sert à charger les icônes de Font Awesome via une CDN,
     sans avoir besoin de télécharger manuellement les fichiers -->

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <script src="../../javascript/accueil.js"></script>
</head>

<body>
  <div class="flex flex-col min-h-screen">

    <!-- Header -->
    <?php echo $header->render(); ?>
    <main>

      
      
      <!-- Sidebar -->
      <?php echo $sidebar->render() ?> 

      <!-- Main Content -->
      <section id="content">

        <?php

      switch ($_SESSION["current_page"]) {
        case "accueil":
          include_once "Match.php";
          break;
        case "classement":
          include_once "Classement.php";
          break;
        case "news":
          include_once "News.php";
          break;
        case "mail":
          include_once "Mail.php";
          break;
        case "sondage":
          include_once "Sondage.php";
          break;
        case "profile":
          include_once "Profile.php";
          break;
        case "comments":
        //   if (!isset($_SESSION['admin_id'])) {
        //     echo "<script>alert('You should sign in to be able to use this service'); window.location.href = '../auth_page/Login.php';</script>";
        //     die();
        //   } else
            include_once "comments/Comments.php";
          break;
        case "comment_form":
          include_once "comments/CommentForm.php";
          break;
        case "club":
          include_once "Club.php";
          break;
        case "player":
          include_once "Player.php";
          break;
      }

      ?>

        <!-- <source> -->
        <div id="admin" class="content-section hidden">
          Espace Administrateur
        </div>
      </section>
    </main>

  </div>
</body>


</html>