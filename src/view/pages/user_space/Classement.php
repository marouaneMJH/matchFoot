<?php
require_once __DIR__ . '/../../../controller/TournamentController.php';

// Get tournament_id from URL or session
$tournament_id = $_GET['tournament_id'] ?? 3; // Add proper validation as needed
$standings = TournamentController::getStandings($tournament_id);


// Helper function to generate last 5 matches status
function getLastFiveMatches($team_id) {
    // This is a placeholder - you'll need to implement this in your TournamentController
    // For now, returning dummy data
    return ['W', 'D', 'W', 'W', 'L'];
}
?>

<div id="classement" class="container mx-auto px-4 py-8 overflow-auto w-[95%] h-[80vh] bg-green-50">
    <section class="league-table bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold text-green-800 mb-6">Classement</h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-green-600 text-white">
                        <th class="px-4 py-3 text-left">#</th>
                        <th class="px-4 py-3 text-left">Club</th>
                        <th class="px-4 py-3">MP</th>
                        <th class="px-4 py-3">W</th>
                        <th class="px-4 py-3">D</th>
                        <th class="px-4 py-3">L</th>
                        <th class="px-4 py-3">GF</th>
                        <th class="px-4 py-3">GA</th>
                        <th class="px-4 py-3">GD</th>
                        <th class="px-4 py-3">Pts</th>
                        <th class="px-4 py-3">Last 5</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($standings as $position => $team): ?>
                    <tr class="hover:bg-green-50 transition-colors <?= ($position < 2) ? 'bg-green-50' : '' ?>">
                        <td class="px-4 py-3 font-semibold text-green-600"><?= $position + 1 ?></td>
                        <td class="px-4 py-3">
                            <div class="flex items-center space-x-3">
                                <img src="<?= $team['logo'] ?? '../../assets/images/equipes_logo/img-placeholder.png' ?>" 
                                     alt="<?= htmlspecialchars($team['name']) ?>" 
                                     class="w-8 h-8 rounded-full">
                                <span class="font-medium"><?= htmlspecialchars($team['name']) ?></span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center"><?= $team['matches_played'] ?></td>
                        <td class="px-4 py-3 text-center"><?= $team['wins'] ?></td>
                        <td class="px-4 py-3 text-center"><?= $team['draws'] ?></td>
                        <td class="px-4 py-3 text-center"><?= $team['losses'] ?></td>
                        <td class="px-4 py-3 text-center"><?= $team['goals_for'] ?></td>
                        <td class="px-4 py-3 text-center"><?= $team['goals_against'] ?></td>
                        <td class="px-4 py-3 text-center font-medium text-green-600"><?= ($team['goal_difference'] > 0 ? '+' : '') . $team['goal_difference'] ?></td>
                        <td class="px-4 py-3 text-center font-bold"><?= $team['points'] ?></td>
                        <td class="px-4 py-3">
                            <div class="flex justify-center space-x-1">
                                <?php 
                                $lastFive = getLastFiveMatches($team['team_id']);
                                foreach ($lastFive as $result): 
                                    $bgColor = match($result) {
                                        'W' => 'bg-green-500',
                                        'L' => 'bg-red-500',
                                        'D' => 'bg-gray-400',
                                        default => 'bg-gray-300'
                                    };
                                ?>
                                <span class="w-5 h-5 rounded-full <?= $bgColor ?> flex items-center justify-center text-white text-xs font-bold">
                                    <?= $result ?>
                                </span>
                                <?php endforeach; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

<style>
    .league-table {
        scrollbar-width: thin;
        scrollbar-color: #16a34a #e5e7eb;
    }
    
    .league-table::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    
    .league-table::-webkit-scrollbar-track {
        background: #e5e7eb;
    }
    
    .league-table::-webkit-scrollbar-thumb {
        background-color: #16a34a;
        border-radius: 4px;
    }
</style>