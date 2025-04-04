<?php
/**
 * Sidebar Component for SoftFootball
 * 
 * This class renders a sidebar with menu items, tournaments, and favorite clubs
 * Preserving the exact structure of the original HTML
 */

class Sidebar {
    private $basePath = '../../';
    
    /**
     * Constructor
     * 
     * @param string $basePath Path to the root directory for assets
     */
    public function __construct($basePath = '../../') {
        $this->basePath = $basePath;
    }
    
    /**
     * Renders the complete sidebar
     * 
     * @return string Complete HTML for sidebar
     */
    public function render() {
        return '
        <aside class="sidebar">
            <h2>MENU</h2>
            <ul id="menu">
                <li data-content="accueil" class="' . (($_SESSION['current_page'] == 'accueil') ? 'active' : '') . '">
                    <i class="fas fa-home"></i> <a href="Accueil.php?Target=accueil"> Accueil </a>
                </li>
                <li data-content="classement" class="' . (($_SESSION['current_page'] == 'classement') ? 'active' : '') . '">
                    <i class="fas fa-list"></i> <a href="Accueil.php?Target=classement">Classement</a>
                </li>
                <li data-content="actualite" class="' . (($_SESSION['current_page'] == 'news') ? 'active' : '') . '">
                    <i class="fas fa-newspaper"></i> <a href="Accueil.php?Target=news">Actualité</a>
                </li>
                <li data-content="sondage" class="' . (($_SESSION['current_page'] == 'sondage') ? 'active' : '') . '">
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
                    <img src="' . $this->basePath . 'assets/images/equipes_logo/BOTOLA_Logo.png" alt="Botola Pro 1" />
                    Botola Pro inwi 1
                </li>
                <li>
                    <img src="' . $this->basePath . 'assets/images/equipes_logo/BOTOLA PRO 2_logo.png" alt="Botola Pro 2" />
                    Botola Pro inwi 2
                </li>
                <li>
                    <img src="' . $this->basePath . 'assets/images/equipes_logo/Coupe du throne.jpeg" alt="Coupe du Throne" />
                    Coupe du Throne
                </li>
                <li>
                    <img src="' . $this->basePath . 'assets/images/equipes_logo/Excellence cup.jpeg" alt="Coupe d\'excellence" />
                    Coupe d\'excellence
                </li>
            </ul>

            <h2>CLUBS PRÉFÉRÉS</h2>
            <ul>
                <li>
                    <img src="' . $this->basePath . 'assets/images/equipes_logo/raja_logo.jpeg" alt="Raja CA" />
                    Raja CA
                </li>
                <li>
                    <img src="' . $this->basePath . 'assets/images/equipes_logo/berkane_logo.jpeg" alt="RS Berkane" />
                    RS Berkane
                </li>
                <li>
                    <img src="' . $this->basePath . 'assets/images/equipes_logo/WYDAD_logo.png" alt="Wydad AC" />
                    Wydad AC
                </li>
                <li>
                    <img src="' . $this->basePath . 'assets/images/equipes_logo/AS far_logo.jpeg" alt="AS far" />
                    AS Far
                </li>
            </ul>
        </aside>';
    }
}