<?php
session_start();
if (isset($_GET["Target"])) {
  $_SESSION["current_page"] = $_GET["Target"];
}

if (!isset($_SESSION["current_page"])) {
  $_SESSION["current_page"] = "accueil";
}

include_once './components/HeaderNavBar.php';

$header = new HeaderNavBar('../../');

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

    <?php echo $header->render(); ?>
    <main>

      <aside class="sidebar">
        <h2>MENU</h2>
        <ul id="menu">
          <li data-content="accueil" class="<?php if ($_SESSION['current_page'] == 'accueil')
                                            echo 'active' ?>">
            <i class="fas fa-home"></i> <a href="Accueil.php?Target=accueil"> Accueil </a>
          </li>
          <li data-content="classement" class="<?php if ($_SESSION['current_page'] == 'classement')
                                                echo 'active' ?>">
            <i class="fas fa-list"></i> <a href="Accueil.php?Target=classement">Classement</a>
          </li>
          <li data-content="actualite" class="<?php if ($_SESSION['current_page'] == 'news')
                                              echo 'active' ?>">
            <i class="fas fa-newspaper"></i> <a href="Accueil.php?Target=news">Actualité</a>
          </li>
          <li data-content="sondage" class="<?php if ($_SESSION['current_page'] == 'sondage')
                                            echo 'active' ?>">
            <i class="fas fa-poll"></i> <a href="Accueil.php?Target=sondage">Sondage</a>
          </li>
          <!-- <li data-content="admin">
            <i class="fas fa-user-lock"></i> Espace Administrateur
          </li> -->
          <li data-content="admin">
            <i class="fas fa-user-lock"></i> <a href="Accueil.php?Target=comments"> TODO </a>
          </li>
        </ul>
        <h2>TOURNOIS MAROCAINES</h2>
        <ul>
          <li>
            <img src="../../assets/images/equipes_logo/BOTOLA_Logo.png" alt="Botola Pro 1" />
            Botola Pro inwi 1
          </li>
          <li>
            <img src="../../assets/images/equipes_logo/BOTOLA PRO 2_logo.png" alt="Botola Pro 2" />
            Botola Pro inwi 2
          </li>
          <li>
            <img src="../../assets/images/equipes_logo/Coupe du throne.jpeg" alt="Coupe du Throne" />
            Coupe du Throne
          </li>
          <li>
            <img src="../../assets/images/equipes_logo/Excellence cup.jpeg" alt="Coupe d'excellence" />
            Coupe d'excellence
          </li>
        </ul>

        <h2>CLUBS PRÉFÉRÉS</h2>
        <ul>
          <li>
            <img src="../../assets/images/equipes_logo/raja_logo.jpeg" alt="Raja CA" />
            Raja CA
          </li>
          <li>
            <img src="../../assets/images/equipes_logo/berkane_logo.jpeg" alt="RS Berkane" />
            RS Berkane
          </li>
          <li>
            <img src="../../assets/images/equipes_logo/WYDAD_logo.png" alt="Wydad AC" />
            Wydad AC
          </li>
          <li>
            <img src="../../assets/images/equipes_logo/AS far_logo.jpeg" alt="AS far" />
            AS Far
          </li>
        </ul>
      </aside>

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