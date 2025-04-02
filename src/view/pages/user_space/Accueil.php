<?php
session_start();
if (isset($_GET["Target"])) {
  $_SESSION["current_page"] = $_GET["Target"];
}
if
(!isset($_SESSION["current_page"])) {
  $_SESSION["current_page"] = "accueil";
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SoftFootball</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="../../styles/accueil.css" />
  <!-- href sert à charger les icônes de Font Awesome via une CDN,
     sans avoir besoin de télécharger manuellement les fichiers -->

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <script src="../../javascript/accueil.js"></script>
</head>

<body>
  <header>
    <div class="logo">
      <img src="../../assets/images/equipes_logo/BOTOLA_Logo.png" alt="SoftFootball Logo" />
      <h1>SoftFootball</h1>
    </div>

    <div class="search-bar">
      <input type="text" placeholder="Rechercher..." />
      <button><i class="fas fa-search"></i></button>
    </div>

    <div class="header-right">
      <a href="./authentification/login.html">
        <button class="sign-in">Se connecter</button>
      </a>
      <i class="fas fa-bell notification-icon"></i>
      <i class="fas fa-cog settings-icon"></i>
    </div>
  </header>

  <nav class="club-logos">
    <span class="club-label">Club sites <i class="fas fa-external-link-alt"></i></span>

    <a href="https://rajacasablanca.com" target="_blank">
      <img src="../../assets/images/equipes_logo/raja_logo.jpeg" alt="Raja CA" />
    </a>

    <a href="https://www.as-far.ma" target="_blank">
      <img src="../../assets/images/equipes_logo/AS far_logo.jpeg" alt="AS FAR" />
    </a>
    <a href="https://www.wac.ma" target="_blank">
      <img src="../../assets/images/equipes_logo/WYDAD_logo.png" alt="Wydad AC" />
    </a>
    <a href="https://www.instagram.com/rsbfootball/?hl=en" target="_blank">
      <img src="../../assets/images/equipes_logo/berkane_logo.jpeg" alt="RS Berkane" />
    </a>

    <a href="https://www.codm.ma" target="_blank">
      <img src="../../assets/images/equipes_logo/COMD_logo.png" alt="CODM" />
    </a>

    <a href="https://www.husafootball.com" target="_blank">
      <img src="../../assets/images/equipes_logo/HUSA_logo.png" alt="HUSA" />
    </a>

    <a href="https://www.fus.ma" target="_blank">
      <img src="../../assets/images/equipes_logo/FUS_logo.png" alt="FUS Rabat" />
    </a>
    <a href="https://www.tas.ma" target="_blank">
      <img src="../../assets/images/equipes_logo/touarga_logo.png" alt="TAS Touarga" />
    </a>

    <a href="https://www.masfes.ma" target="_blank">
      <img src="../../assets/images/equipes_logo/MAS_FES_logo.png" alt="MAS Fès" />
    </a>

    <a href="https://www.irtanger.ma" target="_blank">
      <img src="../../assets/images/equipes_logo/IR tanger_logo.png" alt="IR Tanger" />
    </a>

    <a href="https://www.dhj.ma" target="_blank">
      <img src="../../assets/images/equipes_logo/jdida_logo.jpeg" alt="Difaâ El Jadida" />
    </a>

    <a href="https://www.oc-safi.ma" target="_blank">
      <img src="../../assets/images/equipes_logo/Safi_logo.jpeg" alt="OC Safi" />
    </a>

    <a href="https://www.sccm.ma" target="_blank">
      <img src="../../assets/images/equipes_logo/SCCM_logo.png" alt="SCCM" />
    </a>

    <a href="https://www.chababsoualem.ma" target="_blank">
      <img src="../../assets/images/equipes_logo/SOUALEM_logo.png" alt="Chabab Soualem" />
    </a>

    <a href="https://www.matfoot.ma" target="_blank">
      <img src="../../assets/images/equipes_logo/tetouan_logo.png" alt="MAT Tétouan" />
    </a>

    <a href="https://www.renaissancezemamra.ma" target="_blank">
      <img src="../../assets/images/equipes_logo/Zemamra_logo.jpeg" alt="Renaissance Zemamra" />
    </a>

    <a href="https://www.kacm.ma" target="_blank">
      <img src="../../assets/images/equipes_logo/KACM_logo.png" alt="KACM Marrakech" />
    </a>

    <a href="https://www.kac.ma" target="_blank">
      <img src="../../assets/images/Resized_logo/berchid.png" alt="KAC Kenitra" />
    </a>
  </nav>

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
            <i class="fas fa-poll"></i> <a href="Accueil.php?Target=sondage">Sondage</a></li>
          <!-- <li data-content="admin">
            <i class="fas fa-user-lock"></i> Espace Administrateur
          </li> -->
          <li data-content="admin">
            <i class="fas fa-user-lock"></i> TODO
          </li>
          <!-- code javascript LOGIQUE -->
          <!-- document.addEventListener("DOMContentLoaded", function () {
                    const menuItems = document.querySelectorAll("#menu li");
                    const contentSections = document.querySelectorAll(".content-section");
                
                    menuItems.forEach(item => {
                        item.addEventListener("click", function () {
                            // Retirer 'active' de tous les items
                            menuItems.forEach(li => li.classList.remove("active"));
                
                            // Ajouter 'active' à l'élément cliqué
                            this.classList.add("active");
                
                            // Cacher toutes les sections
                            contentSections.forEach(section => section.classList.add("hidden"));
                
                            // Afficher la section correspondante
                            const sectionId = this.getAttribute("data-content");
                            document.getElementById(sectionId).classList.remove("hidden");
                        });
                    });
                });
                 -->
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
        }

        ?>



      <!-- <source> -->

      <div id="admin" class="content-section hidden">
        Espace Administrateur
      </div>
    </section>
  </main>
</body>

</html>