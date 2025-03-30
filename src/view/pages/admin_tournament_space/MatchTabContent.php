<?php require_once __DIR__ . '/../../../controller/GameMatchController.php'; ?>

<?php
$gameMatches = GameMatchController::indexByTournament(3); ?>
<div id="matchesTab" class="space-y-6">
    <?php foreach ($gameMatches as $match) : ?>
        <div class="bg-white rounded-xl shadow-sm border border-green-100 p-6">
            <h2 class="text-xl font-semibold text-green-900 mb-4"> <?php echo $match[GameMatch::$round] ?></h2>
            <div class="space-y-4">
                <div class="border border-green-100 rounded-lg p-4 hover:bg-green-50 transition-colors">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4 flex-1">
                            <img src=<?php echo isset($match["club1_logo"]) ?  $match["club1_logo"] : " http://efoot/logo?file=img-placeholder.png&dir=image_placeholder" ?> alt="Wydad AC" class="w-12 h-12 rounded-full object-cover">
                            <span class="text-green-900 font-medium"><?php echo $match["club1_name"] ?></span>
                            <span class="text-2xl font-bold text-green-800">2</span>
                        </div>
                        <div class="px-4 py-1 rounded bg-green-100 text-green-800">
                            VS
                        </div>
                        <div class="flex items-center space-x-4 flex-1 justify-end">
                            <span class="text-2xl font-bold text-green-800">1</span>
                            <span class="text-green-900 font-medium"><?php echo $match["club2_name"] ?></span>
                            <img src=<?php echo isset($match["club2_logo"]) ?  $match["club2_logo"] : " http://efoot/logo?file=img-placeholder.png&dir=image_placeholder" ?> alt="Raja CA" class="w-12 h-12 rounded-full object-cover">
                        </div>
                        <!-- Rest of the match card structure remains the same -->
                    </div>
                    <div class="mt-2 text-sm text-green-600">
                        <?php echo "Date: ".$match[GameMatch::$date]."| Time: ".$match[GameMatch::$time]." | Stadium: ".$match["stadium_name"] ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<!-- Add/Edit Match Modal -->
<?php include __DIR__ . '/Add_EditMatchModal.php'; ?>