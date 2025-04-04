<?php
// Fichier: /view/pages/user_space/PlayerDetail.php
?>
<style>
    /* Variables de couleurs */
    :root {
        --color-primary: #166534;
        --color-primary-light: #bbf7d0;
        --color-primary-dark: #14532d;
        --color-white: #ffffff;
        --color-gray-50: #f9fafb;
        --color-gray-100: #f3f4f6;
        --color-gray-200: #e5e7eb;
        --color-gray-600: #4b5563;
        --color-gray-900: #111827;
        --color-attack: #f0fdf4;
        --color-defense: #f9fafb;
        --color-physical: #fef2f2;
        --color-technical: #eff6ff;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --border-radius: 0.5rem;
    }

    /* Styles de base */
    .player-detail-container {
        width: 100%;
        max-width: 100%;
        padding: 0;
        margin: 0;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    /* Player Header avec dégradé et effet 3D */
    .player-header {
        background: linear-gradient(135deg, var(--color-primary-light), var(--color-primary));
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 2.5rem 0;
        width: 100%;
        color: var(--color-white);
        position: relative;
        overflow: hidden;
    }

    .player-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><rect width="100" height="100" fill="none" stroke="%23FFFFFF" stroke-width="0.5" stroke-opacity="0.1"/></svg>');
        opacity: 0.3;
    }

    .player-header-content {
        display: flex;
        align-items: center;
        gap: 2rem;
        position: relative;
        z-index: 1;
        margin-left : 40px;
        margin-bottom  : 20px;
    }

    .player-photo {
        position: relative;
    }

    .player-photo img {
        width: 180px;
        height: 180px;
        object-fit: cover;
        border-radius: 50%;
        border: 4px solid var(--color-white);
        background-color: var(--color-white);
        box-shadow: var(--shadow-lg);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .player-photo img:hover {
        transform: scale(1.05);
        box-shadow: 0 15px 20px -3px rgba(0, 0, 0, 0.15);
    }

    .player-number {
        position: absolute;
        bottom: 0;
        right: 0;
        background-color: var(--color-primary-dark);
        color: var(--color-white);
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.5rem;
        box-shadow: var(--shadow-md);
        border: 2px solid var(--color-white);
    }

    .player-name {
        font-size: 2.25rem;
        font-weight: 800;
        color: var(--color-white);
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        margin-bottom: 0.25rem;
    }

    .player-position {
        display: inline-block;
        color: var(--color-white);
        font-weight: 600;
        font-size: 1.1rem;
        padding: 0.25rem 1rem;
        background-color: rgba(255, 255, 255, 0.2);
        border-radius: 1rem;
        margin-bottom: 0.5rem;
    }

    .player-club {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }

    .player-club img {
        width: 24px;
        height: 24px;
        object-fit: contain;
    }

    .player-club span {
        color: var(--color-white);
        font-weight: 500;
    }

    /* Conteneur principal avec ombre portée */
    .player-content {
        width: 100%;
        padding: 0 1.5rem;
        margin-top: -1.5rem;
        position: relative;
        z-index: 2;
    }

    /* Grid Layout avec espacement amélioré */
    .player-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
        margin: 0;
        width: 100%;
    }

    @media (max-width: 768px) {
        .player-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Cards avec effets d'ombre et animation au survol */
    .player-card {
        background-color: var(--color-white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-md);
        padding: 1.75rem;
        height: 100%;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border-top: 4px solid var(--color-primary);
    }

    .player-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .player-card-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1.25rem;
        color: var(--color-primary);
        border-bottom: 2px solid var(--color-primary-light);
        padding-bottom: 0.75rem;
        position: relative;
        display: flex;
        align-items: center;
    }

    .player-card-title::before {
        content: '';
        display: block;
        width: 3px;
        height: 24px;
        background-color: var(--color-primary);
        margin-right: 10px;
        border-radius: 3px;
    }

    /* Info List avec meilleur espacement */
    .info-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .info-item {
        display: flex;
        align-items: center;
        padding: 0.75rem;
        border-bottom: 1px solid var(--color-gray-100);
        transition: background-color 0.2s ease;
    }

    .info-item:hover {
        background-color: var(--color-gray-50);
        border-radius: 0.25rem;
    }

    .info-icon {
        color: var(--color-primary);
        width: 28px;
        height: 28px;
        margin-right: 1rem;
        stroke: var(--color-primary);
        stroke-width: 2;
        fill: none;
    }

    .info-label {
        font-size: 0.875rem;
        color: var(--color-gray-600);
        margin-bottom: 0.25rem;
    }

    .info-value {
        font-weight: 600;
        font-size: 1.125rem;
        color: var(--color-gray-900);
    }

    /* Stats Grid avec design amélioré */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.25rem;
    }

    .stat-box {
        padding: 1.25rem;
        border-radius: var(--border-radius);
        text-align: center;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: var(--shadow-sm);
    }

    .stat-box:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
    }

    .stat-attack {
        background-color: var(--color-attack);
        border-left: 4px solid #10b981;
    }

    .stat-technical {
        background-color: var(--color-technical);
        border-left: 4px solid #3b82f6;
    }

    .stat-defense {
        background-color: var(--color-defense);
        border-left: 4px solid #6b7280;
    }

    .stat-physical {
        background-color: var(--color-physical);
        border-left: 4px solid #ef4444;
    }

    .stat-label {
        font-size: 0.875rem;
        color: var(--color-gray-600);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        margin-top: 0.5rem;
        color: var(--color-gray-900);
    }

    /* Titres de section avec décoration */
    .career-title, .matches-title {
        margin-top: 3rem;
        font-size: 1.75rem;
        color: var(--color-primary-dark);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 3px solid var(--color-primary-light);
        position: relative;
        font-weight: 700;
    }

    .career-title::after, .matches-title::after {
        content: '';
        position: absolute;
        bottom: -3px;
        left: 0;
        width: 100px;
        height: 3px;
        background-color: var(--color-primary);
    }

    /* Career Progression */
    .career-timeline {
        position: relative;
        margin-left: 20px;
        padding-left: 30px;
    }

    .career-timeline::before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        width: 2px;
        background-color: var(--color-primary-light);
    }

    .career-item {
        position: relative;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background-color: var(--color-white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-md);
        transition: transform 0.2s ease;
    }

    .career-item:hover {
        transform: translateX(5px);
    }

    .career-item::before {
        content: '';
        position: absolute;
        left: -36px;
        top: 1.5rem;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background-color: var(--color-primary);
        border: 4px solid var(--color-white);
        box-shadow: 0 0 0 2px var(--color-primary-light);
    }

    .career-year {
        font-weight: 700;
        color: var(--color-primary);
        font-size: 1.125rem;
        margin-bottom: 0.5rem;
    }

    .career-club {
        font-weight: 600;
        color: var(--color-gray-900);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .career-club img {
        width: 24px;
        height: 24px;
        object-fit: contain;
    }

    .career-details {
        font-size: 0.875rem;
        color: var(--color-gray-600);
    }

    /* Matches section */
    .matches-container {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.25rem;
        margin-bottom: 3rem;
        width: 100%;
    }

    .match-card {
        background-color: var(--color-white);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        box-shadow: var(--shadow-md);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border-left: 4px solid var(--color-primary);
        position: relative;
    }

    .match-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .match-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1.25rem;
        font-size: 0.875rem;
        color: var(--color-gray-600);
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--color-gray-100);
    }

    .match-header div:first-child {
        font-weight: 600;
        padding: 0.25rem 0.75rem;
        background-color: var(--color-gray-100);
        border-radius: 1rem;
    }

    .match-header div:last-child {
        color: var(--color-primary);
        font-weight: 500;
    }

    .match-teams {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .match-team {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 40%;
    }

    .match-team img {
        width: 60px;
        height: 60px;
        object-fit: contain;
        margin-bottom: 0.75rem;
        transition: transform 0.3s ease;
    }

    .match-team:hover img {
        transform: scale(1.1);
    }

    .match-team-name {
        text-align: center;
        font-weight: 600;
        color: var(--color-gray-900);
    }

    .match-vs {
        font-weight: bold;
        color: var(--color-gray-600);
        position: relative;
        padding: 0 1rem;
        font-size: 1.125rem;
    }

    .match-vs::before, .match-vs::after {
        content: '';
        position: absolute;
        top: 50%;
        width: 15px;
        height: 1px;
        background-color: var(--color-gray-300);
    }

    .match-vs::before {
        left: -15px;
    }

    .match-vs::after {
        right: -15px;
    }

    .match-score {
        position: absolute;
        top: -0.75rem;
        left: 50%;
        transform: translateX(-50%);
        background-color: var(--color-gray-900);
        color: var(--color-white);
        padding: 0.25rem 0.75rem;
        border-radius: 0.25rem;
        font-weight: bold;
        font-size: 0.875rem;
    }

    .player-stats {
        display: flex;
        margin-top: 0.5rem;
        font-size: 0.875rem;
        color: var(--color-gray-600);
    }

    .player-stat {
        display: flex;
        align-items: center;
        margin-right: 1.5rem;
    }

    .player-stat svg {
        width: 16px;
        height: 16px;
        margin-right: 0.25rem;
        stroke: var(--color-primary);
    }

    /* Player attributes section */
    .attribute-section {
        margin-top: 2rem;
    }

    .attribute-category {
        margin-bottom: 1.5rem;
    }

    .category-title {
        font-weight: 600;
        color: var(--color-gray-900);
        margin-bottom: 0.75rem;
    }

    .attribute-list {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .attribute-item {
        background-color: var(--color-gray-50);
        padding: 0.75rem;
        border-radius: 0.5rem;
    }

    .attribute-name {
        font-size: 0.875rem;
        color: var(--color-gray-600);
        margin-bottom: 0.25rem;
    }

    .attribute-bar {
        height: 8px;
        background-color: var(--color-gray-200);
        border-radius: 4px;
        overflow: hidden;
    }

    .attribute-value {
        height: 100%;
        background-color: var(--color-primary);
        border-radius: 4px;
    }

    /* No data message */
    .no-data {
        background-color: var(--color-white);
        border-radius: var(--border-radius);
        padding: 3rem 2rem;
        text-align: center;
        color: var(--color-gray-600);
        box-shadow: var(--shadow-md);
        border-left: 4px solid var(--color-primary-light);
    }

    /* Animation pour les cartes au chargement */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .player-card, .career-item, .match-card {
        animation: fadeInUp 0.6s ease forwards;
    }
    
    .player-card:nth-child(even), .career-item:nth-child(even), .match-card:nth-child(even) {
        animation-delay: 0.2s;
    }

    /* Flag */
    .player-flag {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background-color: rgba(255, 255, 255, 0.2);
        padding: 0.25rem 0.75rem;
        border-radius: 1rem;
        color: var(--color-white);
    }

    .player-flag img {
        width: 20px;
        height: 20px;
        object-fit: cover;
        border-radius: 50%;
    }

    /* Ajustements de responsive */
    @media (max-width: 640px) {
        .player-header-content {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }
        
        .player-name {
            font-size: 1.75rem;
        }
        
        .player-card-title, .career-title, .matches-title {
            font-size: 1.25rem;
        }
        
        .stat-value {
            font-size: 1.5rem;
        }

        .player-position, .player-club, .player-flag {
            justify-content: center;
            margin-left: auto;
            margin-right: auto;
        }
    }
</style>

<div class="player-detail-container">
    <!-- Player Header -->
    <div class="player-header">
        <div class="container">
            <div class="player-header-content">
                <div class="player-photo">
                    <?php if (isset($player['profile']) && !empty($player['profile'])): ?>
                        <img src="<?= $player['profile'] ?>" alt="Photo de <?= htmlspecialchars($player['name']) ?> <?= htmlspecialchars($player['surname']) ?>">
                    <?php else: ?>
                        <img src="/Efoot-Project/matchFoot/src/view/assets/images/default-player.png" alt="Photo par défaut">
                    <?php endif; ?>
                    
                    <?php if (isset($player['number']) && !empty($player['number'])): ?>
                        <div class="player-number"><?= htmlspecialchars($player['number']) ?></div>
                    <?php endif; ?>
                </div>
                <div>
                    <h2 class="player-name"><?= htmlspecialchars($player['name']) ?> <?= htmlspecialchars($player['surname']) ?></h2>
                    
                    <?php if (isset($player['position']) && isset($player['position']['name'])): ?>
                        <div class="player-position"><?= htmlspecialchars($player['position']['name']) ?></div>
                    <?php endif; ?>
                    
                    <?php if (isset($player['country']) && isset($player['country']['name'])): ?>
                        <div class="player-flag">
                            <img src="/Efoot-Project/matchFoot/src/view/assets/images/flags/<?= strtolower($player['country']['code'] ?? 'default') ?>.png" alt="Drapeau">
                            <span><?= htmlspecialchars($player['country']['name']) ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($player['club']) && isset($player['club']['name'])): ?>
                        <div class="player-club">
                            <?php if (isset($player['club']['logo']) && !empty($player['club']['logo'])): ?>
                                <img src="<?= $player['club']['logo'] ?>" alt="Logo de <?= htmlspecialchars($player['club']['name']) ?>">
                            <?php endif; ?>
                            <span><?= htmlspecialchars($player['club']['name']) ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Player Details -->
    <div class="player-content">
        <div class="player-grid">
            <!-- Info Card -->
            <div class="player-card">
                <h3 class="player-card-title">Informations Personnelles</h3>
                <div class="info-list">
                    <div class="info-item">
                        <svg class="info-icon" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <div>
                            <p class="info-label">Date de naissance</p>
                            <p class="info-value">
                                <?php 
                                if (isset($player['birth_date']) && !empty($player['birth_date'])) {
                                    echo date('d/m/Y', strtotime($player['birth_date']));
                                    echo " (" . ClubController::calculateAge($player['birth_date']) . " ans)";
                                } else {
                                    echo 'Non spécifiée';
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <svg class="info-icon" viewBox="0 0 24 24">
                            <path d="M20.24 12.24a6 6 0 0 0-8.49-8.49L5 10.5V19h8.5z"></path>
                            <line x1="16" y1="8" x2="2" y2="22"></line>
                            <line x1="17.5" y1="15" x2="9" y2="15"></line>
                        </svg>
                        <div>
                            <p class="info-label">Pied fort</p>
                            <p class="info-value">
                                <?php 
                                if (isset($player['foot'])) {
                                    switch($player['foot']) {
                                        case 'R':
                                            echo 'Droit';
                                            break;
                                        case 'L':
                                            echo 'Gauche';
                                            break;
                                        case 'B':
                                            echo 'Les deux';
                                            break;
                                        default:
                                            echo htmlspecialchars($player['foot']);
                                    }
                                } else {
                                    echo 'Non spécifié';
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <svg class="info-icon" viewBox="0 0 24 24">
                            <path d="M12 3v18"></path>
                            <path d="M3 12h18"></path>
                        </svg>
                        <div>
                            <p class="info-label">Taille</p>
                            <p class="info-value"><?= isset($player['height']) ? htmlspecialchars($player['height']) . ' cm' : 'Non spécifiée' ?></p>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <svg class="info-icon" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                            <line x1="9" y1="9" x2="9.01" y2="9"></line>
                            <line x1="15" y1="9" x2="15.01" y2="9"></line>
                        </svg>
                        <div>
                            <p class="info-label">Poids</p>
                            <p class="info-value"><?= isset($player['weight']) ? htmlspecialchars($player['weight']) . ' kg' : 'Non spécifié' ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Card -->
            <div class="player-card">
                <h3 class="player-card-title">Statistiques</h3>
                
                <?php 
                // Simuler des statistiques pour le joueur
                // Dans une vraie application, ces données viendraient de la base de données
                $stats = [
                    'attack' => rand(60, 95),      // Attaque
                    'defense' => rand(50, 95),     // Défense
                    'technical' => rand(55, 95),   // Technique
                    'physical' => rand(65, 95)     // Physique
                ];
                ?>
                
                <div class="stats-grid">
                    <div class="stat-box stat-attack">
                        <p class="stat-label">Attaque</p>
                        <p class="stat-value"><?= $stats['attack'] ?></p>
                    </div>
                    <div class="stat-box stat-technical">
                        <p class="stat-label">Technique</p>
                        <p class="stat-value"><?= $stats['technical'] ?></p>
                    </div>
                    <div class="stat-box stat-defense">
                        <p class="stat-label">Défense</p>
                        <p class="stat-value"><?= $stats['defense'] ?></p>
                    </div>
                    <div class="stat-box stat-physical">
                        <p class="stat-label">Physique</p>
                        <p class="stat-value"><?= $stats['physical'] ?></p>
                    </div>
                </div>
                
                <!-- Attributes section - plus détaillé -->
                <div class="attribute-section">
                    <div class="attribute-category">
                        <h4 class="category-title">Attaque</h4>
                        <div class="attribute-list">
                            <div class="attribute-item">
                                <div class="attribute-name">Finition</div>
                                <div class="attribute-bar">
                                    <div class="attribute-value" style="width: <?= rand(50, 100) ?>%;"></div>
                                </div>
                            </div>
                            <div class="attribute-item">
                                <div class="attribute-name">Puissance de frappe</div>
                                <div class="attribute-bar">
                                    <div class="attribute-value" style="width: <?= rand(50, 100) ?>%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="attribute-category">
                        <h4 class="category-title">Technique</h4>
                        <div class="attribute-list">
                            <div class="attribute-item">
                                <div class="attribute-name">Dribble</div>
                                <div class="attribute-bar">
                                    <div class="attribute-value" style="width: <?= rand(50, 100) ?>%;"></div>
                                </div>
                            </div>
                            <div class="attribute-item">
                                <div class="attribute-name">Passes</div>
                                <div class="attribute-bar">
                                    <div class="attribute-value" style="width: <?= rand(50, 100) ?>%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       <!-- Career Progression -->
       <h2 class="career-title">Parcours de Carrière</h2>
        
        <div class="career-timeline">
            <!-- Exemple de carrière - Dans une vraie application, ces données viendraient de la base de données -->
            <?php
            // Simuler l'historique de carrière du joueur
            $currentYear = date('Y');
            $playerAge = isset($player['birth_date']) ? ClubController::calculateAge($player['birth_date']) : 25;
            $careerStart = $currentYear - ($playerAge - 18); // Supposons que la carrière a commencé à 18 ans
            
            // Clubs précédents (simulés)
            $previousClubs = [
                [
                    'year_start' => $careerStart,
                    'year_end' => $careerStart + 2,
                    'club_name' => 'Académie de Football',
                    'club_logo' => '/Efoot-Project/matchFoot/src/view/assets/images/default-club.png',
                    'details' => 'Formation initiale'
                ],
                [
                    'year_start' => $careerStart + 2,
                    'year_end' => $careerStart + 4,
                    'club_name' => 'FC Débutant',
                    'club_logo' => '/Efoot-Project/matchFoot/src/view/assets/images/default-club.png',
                    'details' => 'Premier club professionnel'
                ]
            ];
            
            // Club actuel
            $currentClub = [
                'year_start' => $careerStart + 4,
                'year_end' => null,
                'club_name' => isset($player['club']['name']) ? $player['club']['name'] : 'Club Actuel',
                'club_logo' => isset($player['club']['logo']) ? $player['club']['logo'] : '/Efoot-Project/matchFoot/src/view/assets/images/default-club.png',
                'details' => 'Club actuel'
            ];
            
            // Combiner les clubs précédents et le club actuel
            $careerHistory = array_merge($previousClubs, [$currentClub]);
            
            // Afficher l'historique de carrière
            foreach ($careerHistory as $career): 
            ?>
                <div class="career-item">
                    <div class="career-year">
                        <?= $career['year_start'] ?> - <?= $career['year_end'] ? $career['year_end'] : 'Présent' ?>
                    </div>
                    <div class="career-club">
                        <img src="<?= $career['club_logo'] ?>" alt="Logo de <?= htmlspecialchars($career['club_name']) ?>">
                        <span><?= htmlspecialchars($career['club_name']) ?></span>
                    </div>
                    <div class="career-details">
                        <?= htmlspecialchars($career['details']) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Recent Matches -->
        <h2 class="matches-title">Derniers Matchs</h2>
        
        <?php
        // Simuler les derniers matchs joués par le joueur
        // Dans une vraie application, ces données viendraient de la base de données
        $recentMatches = [
            [
                'date' => date('Y-m-d H:i:s', strtotime('-7 days')),
                'home_team' => isset($player['club']['name']) ? $player['club']['name'] : 'Équipe A',
                'home_logo' => isset($player['club']['logo']) ? $player['club']['logo'] : '/Efoot-Project/matchFoot/src/view/assets/images/default-club.png',
                'away_team' => 'Équipe B',
                'away_logo' => '/Efoot-Project/matchFoot/src/view/assets/images/default-club.png',
                'score_home' => 2,
                'score_away' => 1,
                'stadium' => 'Stade Central',
                'player_goals' => 1,
                'player_assists' => 0,
                'played_minutes' => 90
            ],
            [
                'date' => date('Y-m-d H:i:s', strtotime('-14 days')),
                'home_team' => 'Équipe C',
                'home_logo' => '/Efoot-Project/matchFoot/src/view/assets/images/default-club.png',
                'away_team' => isset($player['club']['name']) ? $player['club']['name'] : 'Équipe A',
                'away_logo' => isset($player['club']['logo']) ? $player['club']['logo'] : '/Efoot-Project/matchFoot/src/view/assets/images/default-club.png',
                'score_home' => 0,
                'score_away' => 3,
                'stadium' => 'Stade Est',
                'player_goals' => 2,
                'player_assists' => 1,
                'played_minutes' => 85
            ],
            [
                'date' => date('Y-m-d H:i:s', strtotime('-21 days')),
                'home_team' => isset($player['club']['name']) ? $player['club']['name'] : 'Équipe A',
                'home_logo' => isset($player['club']['logo']) ? $player['club']['logo'] : '/Efoot-Project/matchFoot/src/view/assets/images/default-club.png',
                'away_team' => 'Équipe D',
                'away_logo' => '/Efoot-Project/matchFoot/src/view/assets/images/default-club.png',
                'score_home' => 1,
                'score_away' => 1,
                'stadium' => 'Stade Central',
                'player_goals' => 0,
                'player_assists' => 1,
                'played_minutes' => 90
            ],
        ];
        
        if (!empty($recentMatches)): 
        ?>
            <div class="matches-container">
                <?php foreach ($recentMatches as $match): ?>
                    <div class="match-card">
                        <div class="match-score">
                            <?= $match['score_home'] ?> - <?= $match['score_away'] ?>
                        </div>
                        <div class="match-header">
                            <div><?= date('d/m/Y H:i', strtotime($match['date'])) ?></div>
                            <div><?= htmlspecialchars($match['stadium']) ?></div>
                        </div>
                        <div class="match-teams">
                            <div class="match-team <?= $match['home_team'] == ($player['club']['name'] ?? '') ? 'match-home' : '' ?>">
                                <img src="<?= $match['home_logo'] ?>" alt="Logo de <?= htmlspecialchars($match['home_team']) ?>">
                                <div class="match-team-name"><?= htmlspecialchars($match['home_team']) ?></div>
                            </div>
                            <div class="match-vs">VS</div>
                            <div class="match-team <?= $match['away_team'] == ($player['club']['name'] ?? '') ? 'match-home' : '' ?>">
                                <img src="<?= $match['away_logo'] ?>" alt="Logo de <?= htmlspecialchars($match['away_team']) ?>">
                                <div class="match-team-name"><?= htmlspecialchars($match['away_team']) ?></div>
                            </div>
                        </div>
                        <div class="player-stats">
                            <?php if ($match['player_goals'] > 0): ?>
                                <div class="player-stat">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path>
                                        <path d="M12 6a1 1 0 0 0-1 1v5a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L12 10.586V7a1 1 0 0 0-1-1z"></path>
                                    </svg>
                                    <span>Buts: <?= $match['player_goals'] ?></span>
                                </div>
                            <?php endif; ?>
                            <?php if ($match['player_assists'] > 0): ?>
                                <div class="player-stat">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2z"></path>
                                        <path d="M4 12h16"></path>
                                    </svg>
                                    <span>Passes décisives: <?= $match['player_assists'] ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="player-stat">
                                <svg viewBox="0 0 24 24">
                                    <path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"></path>
                                    <path d="M12 6v6l4 2"></path>
                                </svg>
                                <span>Minutes jouées: <?= $match['played_minutes'] ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-data">Aucun match récent n'est disponible pour ce joueur.</div>
        <?php endif; ?>
    </div>
</div>

<script>
// Script pour les animations ou interactions supplémentaires
document.addEventListener('DOMContentLoaded', function() {
    // Animation au chargement pour les attributs
    const attributeValues = document.querySelectorAll('.attribute-value');
    attributeValues.forEach(function(attr, index) {
        setTimeout(function() {
            attr.style.transition = 'width 1s ease';
        }, index * 100);
    });
});
</script>
