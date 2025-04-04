<?php
/**
 * Header Navigation Bar Component for SoftFootball
 * 
 * This file contains the header and navigation components for the SoftFootball website
 */

// Ensure the NotificationMailButton class is included
require_once 'NotificationMail.php';
require_once __DIR__ . '../../../../../controller/AuthController.php';

class HeaderNavBar {
    private $clubData = [
        ['name' => 'Raja CA', 'logo' => 'raja_logo.jpeg', 'url' => 'https://rajacasablanca.com'],
        ['name' => 'AS FAR', 'logo' => 'AS far_logo.jpeg', 'url' => 'https://www.as-far.ma'],
        ['name' => 'Wydad AC', 'logo' => 'WYDAD_logo.png', 'url' => 'https://www.wac.ma'],
        ['name' => 'RS Berkane', 'logo' => 'berkane_logo.jpeg', 'url' => 'https://www.instagram.com/rsbfootball/?hl=en'],
        ['name' => 'CODM', 'logo' => 'COMD_logo.png', 'url' => 'https://www.codm.ma'],
        ['name' => 'HUSA', 'logo' => 'HUSA_logo.png', 'url' => 'https://www.husafootball.com'],
        ['name' => 'FUS Rabat', 'logo' => 'FUS_logo.png', 'url' => 'https://www.fus.ma'],
        ['name' => 'TAS Touarga', 'logo' => 'touarga_logo.png', 'url' => 'https://www.tas.ma'],
        ['name' => 'MAS Fès', 'logo' => 'MAS_FES_logo.png', 'url' => 'https://www.masfes.ma'],
        ['name' => 'IR Tanger', 'logo' => 'IR tanger_logo.png', 'url' => 'https://www.irtanger.ma'],
        ['name' => 'Difaâ El Jadida', 'logo' => 'jdida_logo.jpeg', 'url' => 'https://www.dhj.ma'],
        ['name' => 'OC Safi', 'logo' => 'Safi_logo.jpeg', 'url' => 'https://www.oc-safi.ma'],
        ['name' => 'SCCM', 'logo' => 'SCCM_logo.png', 'url' => 'https://www.sccm.ma'],
        ['name' => 'Chabab Soualem', 'logo' => 'SOUALEM_logo.png', 'url' => 'https://www.chababsoualem.ma'],
        ['name' => 'MAT Tétouan', 'logo' => 'tetouan_logo.png', 'url' => 'https://www.matfoot.ma'],
        ['name' => 'Renaissance Zemamra', 'logo' => 'Zemamra_logo.jpeg', 'url' => 'https://www.renaissancezemamra.ma'],
        ['name' => 'KACM Marrakech', 'logo' => 'KACM_logo.png', 'url' => 'https://www.kacm.ma'],
        ['name' => 'KAC Kenitra', 'logo' => 'berchid.png', 'url' => 'https://www.kac.ma', 'resized' => true]
    ];
    
    private $basePath = '';
    private $isLoggedIn = false;
    private $mail;
    
    /**
     * Constructor
     * 
     * @param string $basePath Path to the root directory for assets
     * @param bool $isLoggedIn User authentication status
     */
    public function __construct($basePath = '') {
        $this->basePath = $basePath;
        $this->isLoggedIn = AuthController::isLoggedIn();
        
        // Initialize notification mail button if user is logged in
        if($this->isLoggedIn) {
            $this->mail = new NotificationMailButton(AuthController::getUserId());
        }
    }
    
    /**
     * Renders the header section
     * 
     * @return string HTML for the header
     */
    public function renderHeader() {
        // Authentication buttons
        // $authButtons = '';
        
        // if ($this->isLoggedIn) {
        //     $authButtons = '<button class="sign-out">Se déconnecter</button>' . $this->mail->render();
        // } else {
        //     $authButtons = '
        //         <a href="' . $this->basePath . 'authentification/login.html"><button class="sign-in">Se connecter</button></a>
        //         <a href="' . $this->basePath . 'authentification/signup.html"><button class="sign-up">S\'inscrire</button></a>
        //     ';
        // }
            
        return '
        <header>
            <div class="logo">
                <img src="' . $this->basePath . 'assets/images/equipes_logo/BOTOLA_Logo.png" alt="SoftFootball Logo" />
                <h1>SoftFootball</h1>
            </div>
        
            <div class="search-bar">
                <input type="text" placeholder="Rechercher..." />
                <button><i class="fas fa-search"></i></button>
            </div>

            '.
                $this->renderProfileOptions()
            .
            '
        </header>';
    }

    private function renderNotificationMail() {
        if ($this->isLoggedIn) {
            return $this->mail->render();
        }
        return '';
    }

    private function renderSetting() {
        if ($this->isLoggedIn) {
            return '<a href="' . $this->basePath . 'pages/user_space/Profile.php"><i class="fa-solid fa-gear"></i></a>';
        }
        return '';
    }

    private function renderProfileOptions() {
        return '' . $this->renderNotificationMail() . $this->renderSetting() . $this->renderAuthButtons() ;
    }

    private function renderAuthButtons()
    {
        if ($this->isLoggedIn) {
            return '<a href="' . $this->basePath . 'pages/auth_page/Logout.php"><button class="sign-in">Se déconnecter</button></a>';
        } else {
            return '
                <a href="' . $this->basePath .  'pages/auth_page/Login.php"><button class="sign-in">Se connecter</button></a>
                <a href="' . $this->basePath . 'pages/auth_page/Signup.php"><button class="sign-up">S\'inscrire</button></a>
            ';
        }
    }
    
    /**
     * Renders the navigation with club logos
     * 
     * @param int $limit Maximum number of clubs to display (0 for all)
     * @return string HTML for the navigation bar
     */
    public function renderNavigation($limit = 0) {
        $clubsHtml = '';
        $clubs = $limit > 0 ? array_slice($this->clubData, 0, $limit) : $this->clubData;
        
        foreach ($clubs as $club) {
            $imagePath = isset($club['resized']) && $club['resized'] 
                ? $this->basePath . 'assets/images/Resized_logo/' . $club['logo']
                : $this->basePath . 'assets/images/equipes_logo/' . $club['logo'];
                
            $clubsHtml .= '
            <a href="' . $club['url'] . '" target="_blank">
                <img src="' . $imagePath . '" alt="' . $club['name'] . '" />
            </a>';
        }
        
        return '
        <nav class="club-logos">
            <span class="club-label">Club sites <i class="fas fa-external-link-alt"></i></span>
            ' . $clubsHtml . '
        </nav>';
    }
    
    /**
     * Renders both header and navigation
     * 
     * @param int $clubLimit Maximum number of clubs to display (0 for all)
     * @return string Complete HTML for header and navigation
     */
    public function render($clubLimit = 0) {
        return $this->renderHeader() . $this->renderNavigation($clubLimit);
    }
}
?>