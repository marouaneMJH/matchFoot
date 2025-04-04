


<?php



?>

<div id="standingsTab" class="hidden">
    <div class="bg-white rounded-xl shadow-sm border border-green-100 overflow-hidden">
        <table class="min-w-full divide-y divide-green-200">
            <thead class="bg-green-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Position</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Team</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Played</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Won</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Drawn</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Lost</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">GF</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">GA</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">GD</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Points</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-green-100">
                <?php foreach ($standings as $position => $team): ?>
                <tr class="hover:bg-green-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-900"><?= $position + 1 ?></td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <img class="h-8 w-8 rounded-full" 
                                 src="<?= $team['logo'] ?? '../../../../public/uploads/image_placeholder/img-placeholder.png' ?>" 
                                 alt="<?= htmlspecialchars($team['name']) ?>">
                            <span class="ml-2 text-sm font-medium text-green-900"><?= htmlspecialchars($team['name']) ?></span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600"><?= $team['matches_played'] ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600"><?= $team['wins'] ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600"><?= $team['draws'] ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600"><?= $team['losses'] ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600"><?= $team['goals_for'] ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600"><?= $team['goals_against'] ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600"><?= ($team['goal_difference'] > 0 ? '+' : '') . $team['goal_difference'] ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-900"><?= $team['points'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>