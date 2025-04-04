<?php
// Fichier: /view/pages/user_space/ClubDetail.php
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
        --color-wins: #ecfdf5;
        --color-draws: #f9fafb;
        --color-losses: #fef2f2;
        --color-goals: #eff6ff;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --border-radius: 0.5rem;
    }

    /* Styles de base */
    .club-detail-container {
        width: 100%;
        max-width: 100%;
        padding: 0;
        margin: 0;
        
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    /* Team Header avec dégradé et effet 3D */
    .team-header {
        background: linear-gradient(135deg, var(--color-primary-light), var(--color-primary));
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 2.5rem 0;
        width: 100%;
        color: var(--color-white);
        position: relative;
        overflow: hidden;
        
    }

    .team-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><rect width="100" height="100" fill="none" stroke="%23FFFFFF" stroke-width="0.5" stroke-opacity="0.1"/></svg>');
        opacity: 0.3;
        
    }

    .team-header-content {
        display: flex;
        align-items: center;
        gap: 2rem;
        position: relative;
        z-index: 1;
        margin-left : 40px;
        margin-bottom  : 20px;
    }

    .team-logo {
        position: relative;
    }

    .team-logo img {
        width: 150px;
        height: 150px;
        object-fit: contain;
        border-radius: 50%;
        border: 4px solid var(--color-white);
        padding: 5px;
        background-color: var(--color-white);
        box-shadow: var(--shadow-lg);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .team-logo img:hover {
        transform: scale(1.05);
        box-shadow: 0 15px 20px -3px rgba(0, 0, 0, 0.15);
    }

    .team-name {
        font-size: 2.25rem;
        font-weight: 800;
        color: var(--color-white);
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        margin-bottom: 0.25rem;
    }

    .team-subtitle {
        color: var(--color-white);
        font-weight: 600;
        font-style: italic;
        font-size: 1.25rem;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
    }

    /* Conteneur principal avec ombre portée */
    .club-content {
        width: 100%;
        padding: 0 1.5rem;
        margin-top: -1.5rem;
        position: relative;
        z-index: 2;
    }

    /* Grid Layout avec espacement amélioré */
    .club-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
        margin: 0;
        width: 100%;
    }

    @media (max-width: 768px) {
        .club-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Cards avec effets d'ombre et animation au survol */
    .club-card {
        background-color: var(--color-white);
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-md);
        padding: 1.75rem;
        height: 100%;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border-top: 4px solid var(--color-primary);
    }

    .club-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .club-card-title {
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

    .club-card-title::before {
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

    .stat-wins {
        background-color: var(--color-wins);
        border-left: 4px solid #10b981;
    }

    .stat-draws {
        background-color: var(--color-draws);
        border-left: 4px solid #6b7280;
    }

    .stat-losses {
        background-color: var(--color-losses);
        border-left: 4px solid #ef4444;
    }

    .stat-goals {
        background-color: var(--color-goals);
        border-left: 4px solid #3b82f6;
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
    .players-title, .matches-title {
        margin-top: 3rem;
        font-size: 1.75rem;
        color: var(--color-primary-dark);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 3px solid var(--color-primary-light);
        position: relative;
        font-weight: 700;
    }

    .players-title::after, .matches-title::after {
        content: '';
        position: absolute;
        bottom: -3px;
        left: 0;
        width: 100px;
        height: 3px;
        background-color: var(--color-primary);
    }

    /* Players section */
    .players-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
        width: 100%;
    }

    .player-card {
        background-color: var(--color-white);
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .player-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
    }

    .player-image {
        height: 220px;
        background-color: var(--color-gray-100);
        position: relative;
        overflow: hidden;
    }

    .player-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .player-card:hover .player-image img {
        transform: scale(1.1);
    }

    .player-number {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: var(--color-primary);
        color: white;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.125rem;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .player-info {
        padding: 1.25rem;
        border-top: 3px solid var(--color-primary);
    }

    .player-name {
        font-weight: 700;
        margin-bottom: 0.5rem;
        font-size: 1.125rem;
        color: var(--color-gray-900);
    }

    .player-position {
        color: var(--color-primary);
        font-size: 0.925rem;
        margin-bottom: 0.75rem;
        font-weight: 600;
        display: inline-block;
        padding: 0.25rem 0.75rem;
        background-color: var(--color-primary-light);
        border-radius: 1rem;
    }

    .player-stats {
        display: flex;
        font-size: 0.825rem;
        color: var(--color-gray-600);
        margin-top: 0.5rem;
    }

    .player-stats div {
        margin-right: 1.25rem;
        display: flex;
        align-items: center;
    }

    .player-stats div::before {
        content: '';
        display: inline-block;
        width: 8px;
        height: 8px;
        margin-right: 5px;
        background-color: var(--color-primary);
        border-radius: 50%;
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

    .match-home {
        color: var(--color-primary);
    }

    .match-home .match-team-name {
        color: var(--color-primary);
        font-weight: 700;
    }

    /* Contrôles de filtrage améliorés */
    .filter-controls {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        width: 100%;
        background-color: var(--color-gray-50);
        padding: 1rem;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-sm);
    }

    .search-input, .filter-select {
        padding: 0.75rem 1rem;
        border: 1px solid var(--color-gray-200);
        border-radius: 0.5rem;
        font-size: 0.875rem;
        box-shadow: var(--shadow-sm);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .search-input:focus, .filter-select:focus {
        outline: none;
        border-color: var(--color-primary);
        box-shadow: 0 0 0 3px rgba(22, 101, 52, 0.2);
    }

    .search-input {
        flex-grow: 1;
        min-width: 200px;
    }

    .filter-select {
        min-width: 150px;
    }

    /* Message pas de données */
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

    .club-card, .player-card, .match-card {
        animation: fadeInUp 0.6s ease forwards;
    }
    
    .player-card:nth-child(even) {
        animation-delay: 0.2s;
    }
    
    .player-card:nth-child(3n) {
        animation-delay: 0.3s;
    }
    
    .match-card:nth-child(even) {
        animation-delay: 0.2s;
    }

    /* Ajustements de responsive */
    @media (max-width: 640px) {
        .team-header-content {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }
        
        .team-name {
            font-size: 1.75rem;
        }
        
        .club-card-title, .players-title, .matches-title {
            font-size: 1.25rem;
        }
        
        .stat-value {
            font-size: 1.5rem;
        }
    }
</style>

<div class="club-detail-container">
    <!-- Team Header -->
    <div class="team-header">
        <div class="container">
            <div class="team-header-content">
                <div class="team-logo">
                     <?php if (isset($club['logo']) && !empty($club['logo'])): ?>
                        <img src="<?= $club['logo'] ?>" alt="Logo de <?= htmlspecialchars($club['name']) ?>">
                    <?php else: ?>
                        <img src="/Efoot-Project/matchFoot/src/view/assets/images/logo.jpg" alt="Logo par défaut">
                    <?php endif; ?>
                </div>
                <div>
                    <h2 class="team-name"><?= htmlspecialchars($club['name']) ?></h2>
                    <p class="team-subtitle">"<?= htmlspecialchars($club['nickname']) ?>"</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Details -->
    <div class="club-content">
        <div class="club-grid">
            <!-- Info Card -->
            <div class="club-card">
                <h3 class="club-card-title">Informations Générales</h3>
                <div class="info-list">
                    <div class="info-item">
                        <svg class="info-icon" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <div>
                            <p class="info-label">Année de création</p>
                            <p class="info-value"><?= htmlspecialchars($club['founded_at']) ?></p>
                        </div>
                    </div>
                    <div class="info-item">
                        <svg class="info-icon" viewBox="0 0 24 24">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <div>
                            <p class="info-label">Stade</p>
                            <p class="info-value"><?= htmlspecialchars($club['stadium']['name'] ?? 'Non spécifié') ?></p>
                        </div>
                    </div>
                    <div class="info-item">
                        <svg class="info-icon" viewBox="0 0 24 24">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <div>
                            <p class="info-label">Entraîneur</p>
                            <p class="info-value"><?= htmlspecialchars($club['trainer']['name'] ?? 'Non spécifié') ?></p>
                        </div>
                    </div>
                    <div class="info-item">
                        <svg class="info-icon" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon>
                        </svg>
                            <div>
                                <p class="info-label">Ville</p>
                                <p class="info-value">
                                    <?php
                                    if (isset($club['stadium']) && isset($club['stadium']['ville']) && isset($club['stadium']['ville']['name'])) {
                                        echo htmlspecialchars($club['stadium']['ville']['name']);
                                    } else {
                                        echo 'Non spécifiée';
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                </div>
            </div>

            <!-- Stats Card -->
            <div class="club-card">
                <h3 class="club-card-title">Statistiques de la Saison</h3>
                <?php 
                // Exemple de données statistiques
                $stats = [
                    'wins' => 0,
                    'draws' => 0,
                    'losses' => 0,
                    'goals_for' => 0,
                    'goals_against' => 0
                ];
                
                // Exemple de calcul des statistiques
                $upcomingMatches = ClubController::getUpcomingMatches($club['id']);
                foreach ($upcomingMatches as $match) {
                    if (isset($match['score1']) && isset($match['score2'])) {
                        if ($match['score1'] > $match['score2'] && $match['club1_id'] == $club['id']) {
                            $stats['wins']++;
                            $stats['goals_for'] += $match['score1'];
                            $stats['goals_against'] += $match['score2'];
                        } elseif ($match['score2'] > $match['score1'] && $match['club2_id'] == $club['id']) {
                            $stats['wins']++;
                            $stats['goals_for'] += $match['score2'];
                            $stats['goals_against'] += $match['score1'];
                        } elseif ($match['score1'] == $match['score2']) {
                            $stats['draws']++;
                            if ($match['club1_id'] == $club['id']) {
                                $stats['goals_for'] += $match['score1'];
                                $stats['goals_against'] += $match['score2'];
                            } else {
                                $stats['goals_for'] += $match['score2'];
                                $stats['goals_against'] += $match['score1'];
                            }
                        } else {
                            $stats['losses']++;
                            if ($match['club1_id'] == $club['id']) {
                                $stats['goals_for'] += $match['score1'];
                                $stats['goals_against'] += $match['score2'];
                            } else {
                                $stats['goals_for'] += $match['score2'];
                                $stats['goals_against'] += $match['score1'];
                            }
                        }
                    }
                }
                ?>
                
                <div class="stats-grid">
                    <div class="stat-box stat-wins">
                        <p class="stat-label">Victoires</p>
                        <p class="stat-value"><?= $stats['wins'] ?></p>
                    </div>
                    <div class="stat-box stat-draws">
                        <p class="stat-label">Nuls</p>
                        <p class="stat-value"><?= $stats['draws'] ?></p>
                    </div>
                    <div class="stat-box stat-losses">
                        <p class="stat-label">Défaites</p>
                        <p class="stat-value"><?= $stats['losses'] ?></p>
                    </div>
                    <div class="stat-box stat-goals">
                        <p class="stat-label">Buts</p>
                        <p class="stat-value"><?= $stats['goals_for'] ?> - <?= $stats['goals_against'] ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Players Section -->
        <h2 class="players-title">Effectif</h2>

        <div class="filter-controls">
            <input type="text" id="player-search" class="search-input" placeholder="Rechercher un joueur...">
            <select id="position-filter" class="filter-select">
                <option value="">Toutes les positions</option>
                <option value="Gardien">Gardien</option>
                <option value="Défenseur">Défenseur</option>
                <option value="Milieu">Milieu</option>
                <option value="Attaquant">Attaquant</option>
            </select>
        </div>

        <?php if (!empty($players)): ?>
            <div class="players-container">
                <?php foreach ($players as $player): ?>
                    <!-- Ajout d'un lien vers la page de détail du joueur -->
                    <a href="Accueil.php?Target=player&id=<?= $player['id'] ?>" 
    class="player-card" 
    data-position="<?= htmlspecialchars($player['position_name'] ?? '') ?>"
    style="text-decoration: none; color: inherit;">
                        <div class="player-image">
                            <?php if (isset($player['profile_path']) && !empty($player['profile_path'])): ?>
                                <img src="http://efoot/logo?file=<?= $player['profile_path'] ?>&dir=player_profiles" alt="<?= htmlspecialchars($player['name'] ?? '') ?>">
                            <?php else: ?>
                                <img src="/Efoot-Project/matchFoot/src/view/assets/images/default-player.png" alt="Photo par défaut">
                            <?php endif; ?>
                            
                            <?php if (isset($player['number']) && !empty($player['number'])): ?>
                                <div class="player-number"><?= htmlspecialchars($player['number']) ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="player-info">
                            <h3 class="player-name"><?= htmlspecialchars($player['name'] ?? '') ?> <?= htmlspecialchars($player['surname'] ?? '') ?></h3>
                            <p class="player-position"><?= htmlspecialchars($player['position_name'] ?? '') ?></p>
                            <div class="player-stats">
                                <div>Âge: <?= ClubController::calculateAge($player['birth_date'] ?? '') ?> ans</div>
                                <?php if (isset($player['nationality']) && !empty($player['nationality'])): ?>
                                    <div>Nationalité: <?= htmlspecialchars($player['nationality']) ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-data">Aucun joueur n'est associé à ce club pour le moment.</div>
        <?php endif; ?>

        <!-- Matches Section -->
        <h2 class="matches-title">Prochains Matchs</h2>
        
        <?php 
        $upcomingMatches = ClubController::getUpcomingMatches($club['id']);
        if (!empty($upcomingMatches)): 
        ?>
            <div class="matches-container">
                <?php foreach ($upcomingMatches as $match): ?>
                    <div class="match-card">
                        <div class="match-header">
                            <div><?= date('d/m/Y H:i', strtotime($match['date'])) ?></div>
                            <div><?= htmlspecialchars($match['stadium_name']) ?></div>
                        </div>
                        <div class="match-teams">
                            <div class="match-team <?= $match['club1_id'] == $club['id'] ? 'match-home' : '' ?>">
                                <img src="<?= $match['home_logo_url'] ?>" alt="<?= htmlspecialchars($match['home_team_name']) ?>">
                                <div class="match-team-name"><?= htmlspecialchars($match['home_team_name']) ?></div>
                            </div>
                            <div class="match-vs">VS</div>
                            <div class="match-team <?= $match['club2_id'] == $club['id'] ? 'match-home' : '' ?>">
                                <img src="<?= $match['away_logo_url'] ?>" alt="<?= htmlspecialchars($match['away_team_name']) ?>">
                                <div class="match-team-name"><?= htmlspecialchars($match['away_team_name']) ?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-data">Aucun match à venir n'est programmé pour ce club.</div>
        <?php endif; ?>
    </div>
</div>

<script>
// Filtrage des joueurs
document.addEventListener('DOMContentLoaded', function() {
    const playerSearch = document.getElementById('player-search');
    const positionFilter = document.getElementById('position-filter');
    const playerCards = document.querySelectorAll('.player-card');
    
    if (playerSearch && positionFilter) {
        playerSearch.addEventListener('input', function() {
            filterPlayers();
        });
        
        positionFilter.addEventListener('change', function() {
            filterPlayers();
        });
        
        function filterPlayers() {
            const searchTerm = playerSearch.value.toLowerCase();
            const selectedPosition = positionFilter.value;
            
            playerCards.forEach(card => {
                const playerName = card.querySelector('.player-name').textContent.toLowerCase();
                const playerPosition = card.dataset.position;
                
                const nameMatch = playerName.includes(searchTerm);
                const positionMatch = !selectedPosition || playerPosition === selectedPosition;
                
                card.style.display = nameMatch && positionMatch ? 'block' : 'none';
            });
        }
    }
});
</script>