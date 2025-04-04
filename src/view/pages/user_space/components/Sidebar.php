<?php
/**
 * Sidebar Component for SoftFootball
 * 
 * This class renders a sidebar with menu items, tournaments, and favorite clubs
 */

class Sidebar {
    private $basePath = '';
    private $activeMenuItem = 'accueil';
    
    // Menu items configuration
    private $menuItems = [
        ['id' => 'accueil', 'icon' => 'fa-home', 'label' => 'Accueil'],
        ['id' => 'classement', 'icon' => 'fa-list', 'label' => 'Classement'],
        ['id' => 'actualite', 'icon' => 'fa-newspaper', 'label' => 'Actualité'],
        ['id' => 'sondage', 'icon' => 'fa-poll', 'label' => 'Sondage'],
        ['id' => 'admin', 'icon' => 'fa-user-lock', 'label' => 'TODO']
    ];
    
    // Tournaments configuration
    private $tournaments = [
        ['id' => 'botola_pro_1', 'image' => 'botola_pro_logo/BOTOLA_PRO_2_logo.png', 'label' => 'Botola Pro inwi 1'],
        ['id' => 'botola_pro_2', 'image' => 'equipes_logo/BOTOLA PRO 2_logo.png', 'label' => 'Botola Pro inwi 2'],
        ['id' => 'coupe_throne', 'image' => 'equipes_logo/Coupe du throne.jpeg', 'label' => 'Coupe du Throne'],
        ['id' => 'coupe_excellence', 'image' => 'equipes_logo/Excellence cup.jpeg', 'label' => 'Coupe d\'excellence']
    ];
    
    // Favorite clubs configuration
    private $favoriteClubs = [
        ['id' => 'raja', 'image' => 'equipes_logo/raja_logo.jpeg', 'label' => 'Raja CA'],
        ['id' => 'berkane', 'image' => 'equipes_logo/berkane_logo.jpeg', 'label' => 'RS Berkane'],
        ['id' => 'wydad', 'image' => 'equipes_logo/WYDAD_logo.png', 'label' => 'Wydad AC'],
        ['id' => 'asfar', 'image' => 'equipes_logo/AS far_logo.jpeg', 'label' => 'AS Far']
    ];
    
    /**
     * Constructor
     * 
     * @param string $basePath Path to the root directory for assets
     * @param string $activeMenuItem The currently active menu item
     */
    public function __construct($basePath = '', $activeMenuItem = 'accueil') {
        $this->basePath = $basePath;
        $this->activeMenuItem = $activeMenuItem;
    }
    
    /**
     * Set the active menu item
     * 
     * @param string $menuItemId ID of the menu item to set as active
     * @return $this For method chaining
     */
    public function setActiveMenuItem($menuItemId) {
        $this->activeMenuItem = $menuItemId;
        return $this;
    }
    
    /**
     * Add a custom menu item
     * 
     * @param string $id Unique identifier for the menu item
     * @param string $icon FontAwesome icon class (without 'fas')
     * @param string $label Display text for the menu item
     * @return $this For method chaining
     */
    public function addMenuItem($id, $icon, $label) {
        $this->menuItems[] = [
            'id' => $id,
            'icon' => $icon,
            'label' => $label
        ];
        return $this;
    }
    
    /**
     * Add a custom tournament
     * 
     * @param string $id Unique identifier for the tournament
     * @param string $image Path to tournament logo (relative to assets directory)
     * @param string $label Display text for the tournament
     * @return $this For method chaining
     */
    public function addTournament($id, $image, $label) {
        $this->tournaments[] = [
            'id' => $id,
            'image' => $image,
            'label' => $label
        ];
        return $this;
    }
    
    /**
     * Add a favorite club
     * 
     * @param string $id Unique identifier for the club
     * @param string $image Path to club logo (relative to assets directory)
     * @param string $label Display text for the club
     * @return $this For method chaining
     */
    public function addFavoriteClub($id, $image, $label) {
        $this->favoriteClubs[] = [
            'id' => $id,
            'image' => $image,
            'label' => $label
        ];
        return $this;
    }
    
    /**
     * Renders the menu section
     * 
     * @return string HTML for the menu section
     */
    public function renderMenuSection() {
        $menuHtml = '';
        
        foreach ($this->menuItems as $item) {
            $isActive = ($item['id'] === $this->activeMenuItem);
            $activeClass = $isActive ? 'text-blue-600 font-semibold active' : 'text-gray-700';
            
            $menuHtml .= '
            <li data-content="' . htmlspecialchars($item['id']) . '" class="flex items-center gap-3 p-2.5 rounded-md ' . $activeClass . ' cursor-pointer hover:bg-gray-100 transition-colors">
                <i class="fas ' . htmlspecialchars($item['icon']) . ' text-sm"></i>
                <span>' . htmlspecialchars($item['label']) . '</span>
            </li>';
        }
        
        return '
        <h2 class="text-gray-800 font-bold text-lg mb-3">MENU</h2>
        <ul class="mb-6" id="menu">
            ' . $menuHtml . '
        </ul>';
    }
    
    /**
     * Renders the tournaments section
     * 
     * @return string HTML for the tournaments section
     */
    public function renderTournamentsSection() {
        $tournamentsHtml = '';
        
        foreach ($this->tournaments as $tournament) {
            $tournamentsHtml .= '
            <li class="flex items-center gap-3 p-2.5 text-gray-700 cursor-pointer hover:bg-gray-100 transition-colors">
                <img 
                    src="' . $this->basePath . 'assets/images/' . htmlspecialchars($tournament['image']) . '" 
                    alt="' . htmlspecialchars($tournament['label']) . '" 
                    class="w-6 h-6 object-contain"
                />
                <span>' . htmlspecialchars($tournament['label']) . '</span>
            </li>';
        }
        
        return '
        <h2 class="text-gray-800 font-bold text-lg mb-3">TOURNOIS MAROCAINES</h2>
        <ul class="mb-6">
            ' . $tournamentsHtml . '
        </ul>';
    }
    
    /**
     * Renders the favorite clubs section
     * 
     * @return string HTML for the favorite clubs section
     */
    public function renderFavoriteClubsSection() {
        $clubsHtml = '';
        
        foreach ($this->favoriteClubs as $club) {
            $clubsHtml .= '
            <li class="flex items-center gap-3 p-2.5 text-gray-700 cursor-pointer hover:bg-gray-100 transition-colors">
                <img 
                    src="' . $this->basePath . 'assets/images/' . htmlspecialchars($club['image']) . '" 
                    alt="' . htmlspecialchars($club['label']) . '" 
                    class="w-6 h-6 object-contain"
                />
                <span>' . htmlspecialchars($club['label']) . '</span>
            </li>';
        }
        
        return '
        <h2 class="text-gray-800 font-bold text-lg mb-3">CLUBS PRÉFÉRÉS</h2>
        <ul>
            ' . $clubsHtml . '
        </ul>';
    }
    
    /**
     * Renders the complete sidebar
     * 
     * @param bool $includeMenu Whether to include the menu section
     * @param bool $includeTournaments Whether to include the tournaments section
     * @param bool $includeFavoriteClubs Whether to include the favorite clubs section
     * @return string Complete HTML for sidebar
     */
    public function render($includeMenu = true, $includeTournaments = true, $includeFavoriteClubs = true) {
        $html = '<aside class="w-64 bg-white border-r border-gray-200 p-5 h-screen overflow-y-auto">';
        
        if ($includeMenu) {
            $html .= $this->renderMenuSection();
        }
        
        if ($includeTournaments) {
            $html .= $this->renderTournamentsSection();
        }
        
        if ($includeFavoriteClubs) {
            $html .= $this->renderFavoriteClubsSection();
        }
        
        $html .= '</aside>';
        $html .= '<br/>' . $this->getMenuClickHandler();
        

        
        
        return $html;
    }
    
    /**
     * Set custom click handler for menu items (JavaScript function)
     * 
     * @param string $jsFunction JavaScript function name to call on click
     * @return string JavaScript to handle click events
     */
    public function getMenuClickHandler($jsFunction = 'handleMenuClick') {
        return '
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const menuItems = document.querySelectorAll("#menu li");
                menuItems.forEach(item => {
                    item.addEventListener("click", function() {
                        // Remove active class from all items
                        menuItems.forEach(i => {
                            i.classList.remove("active", "text-blue-600", "font-semibold");
                            i.classList.add("text-gray-700");
                        });
                        
                        // Add active class to clicked item
                        this.classList.add("active", "text-blue-600", "font-semibold");
                        this.classList.remove("text-gray-700");
                        
                        // Call custom handler function if defined
                        if (typeof ' . $jsFunction . ' === "function") {
                            ' . $jsFunction . '(this.getAttribute("data-content"));
                        }
                    });
                });
            });
        </script>';
    }
}
?>