<?php require_once __DIR__ . '/../../../controller/GameMatchController.php';

$liveMatches = $upcomingMatches = $finishedMatches = [];
foreach ($gameMatches as $match) {
    if ($match['status'] === "Upcoming") {
        $upcomingMatches[] = $match;
    } elseif ($match['status'] === "Finished") {
        $finishedMatches[] = $match;
    } else {
        $liveMatches[] = $match;
    }
}
?>


<div id="matchesTab" class="space-y-6">
    <div class="flex-column space-y-6 mb-4">
        <div class="flex items-center justify-between mb-4 hover:bg-green-100 transition-colors p-2 rounded-lg cursor-pointer" onclick="toggleSection('liveSection')">
            <div class="text-xl font-semibold text-green-800 "> Live Matches</div>
            <svg
                id="icon-liveSection"
                style="transition: transform 0.3s ease-in-out;transform: rotate(180deg);"
                class="w-6 h-6 text-green-800 transform transition-transform duration-300 ease-in-out"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 9l-7 7-7-7" />
            </svg>

        </div>
        <div id="liveSection"
            style="max-height: 1000px;transition: max-height 0.5s ease-in-out;overflow: hidden;"
            class="flex-col space-y-4">
            <?php if (empty($liveMatches)) : ?>
                <div class="bg-white  rounded-lg shadow-sm border border-green-100 overflow-hidden">
                    <div class="p-8 flex flex-col items-center justify-center">
                        <h3 class="text-lg font-medium text-gray-100 mb-2">No Matches Found</h3>
                        <p class="text-gray-100 text-center max-w-md">
                            There are currently no matches available for this selection. Please check back later.
                        </p>
                    </div>
                </div>
            <?php endif; ?>
            <?php foreach ($liveMatches as $match) : ?>

                <div class="bg-white rounded-xl shadow-sm border border-green-100 p-6 ">
                    <h2 class="text-xl font-semibold  mb-4"> Round: <?php echo $match[GameMatch::$round] ?></h2>
                    <div class="space-y-4">
                        <div class="border border-green-100 rounded-lg p-4 hover:bg-green-50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4 flex-1">
                                    <img src=<?php echo isset($match["club1_logo"]) ?  $match["club1_logo"] : " http://efoot/logo?file=img-placeholder.png&dir=image_placeholder" ?> alt="Wydad AC" class="w-12 h-12 rounded-full object-cover">
                                    <span class="font-medium"><?php echo $match["club1_name"] ?></span>
                                    <span class="text-2xl font-bold ">2</span>
                                </div>
                                <div class="px-4 py-1 rounded bg-gray-100 text-gray-800">
                                    VS
                                </div>
                                <div class="flex items-center space-x-4 flex-1 justify-end">
                                    <span class="text-2xl font-bold ">1</span>
                                    <span class=" font-medium"><?php echo $match["club2_name"] ?></span>
                                    <img src=<?php echo isset($match["club2_logo"]) ?  $match["club2_logo"] : " http://efoot/logo?file=img-placeholder.png&dir=image_placeholder" ?> alt="Raja CA" class="w-12 h-12 rounded-full object-cover">
                                </div>
                                <!-- Rest of the match card structure remains the same -->
                            </div>
                            <div class="mt-2 text-sm text-gray-400">
                                <?php echo "Date: " . $match[GameMatch::$date] . "| Time: " . $match[GameMatch::$time] . " | Stadium: " . $match["stadium_name"] ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="flex-col space-y-6 mb-4">
        <div class="flex items-center justify-between mb-4 hover:bg-green-100 transition-colors p-2 rounded-lg cursor-pointer" onclick="toggleSection('UpcomingSection')">
            <div class="text-xl font-semibold text-green-800 "> Scheduled Matches</div>
            <svg
                id="icon-UpcomingSection"
                style="transition: transform 0.3s ease-in-out;transform: rotate(180deg);"
                class="w-6 h-6 text-green-800 transform transition-transform duration-300 ease-in-out"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 9l-7 7-7-7" />
            </svg>

        </div>
        <div id="UpcomingSection"
            style="max-height: 1000px;transition: max-height 0.5s ease-in-out;overflow: hidden;"
            class="flex-col space-y-4">
            <?php if (empty($upcomingMatches)) : ?>
                <div class="bg-white  rounded-lg shadow-sm border border-green-100 overflow-hidden">
                    <div class="p-8 flex flex-col items-center justify-center">
                        <h3 class="text-lg font-medium text-gray-100 mb-2">No Matches Found</h3>
                        <p class="text-gray-100 text-center max-w-md">
                            There are currently no matches available for this selection. Please check back later.
                        </p>
                    </div>
                </div>
            <?php endif; ?>
            <?php foreach ($upcomingMatches as $match) : ?>
                <div class="bg-white rounded-xl shadow-sm border border-green-100 p-6 ">
                    <h2 class="text-xl font-semibold  mb-4"> Round: <?php echo $match[GameMatch::$round] ?></h2>
                    <div class="space-y-4">
                        <div class="border border-green-100 rounded-lg p-4 hover:bg-green-50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4 flex-1">
                                    <img src=<?php echo isset($match["club1_logo"]) ?  $match["club1_logo"] : " http://efoot/logo?file=img-placeholder.png&dir=image_placeholder" ?> alt="Wydad AC" class="w-12 h-12 rounded-full object-cover">
                                    <span class="font-medium"><?php echo $match["club1_name"] ?></span>
                                    <span class="text-2xl font-bold ">2</span>
                                </div>
                                <div class="px-4 py-1 rounded bg-gray-100 text-gray-800">
                                    VS
                                </div>
                                <div class="flex items-center space-x-4 flex-1 justify-end">
                                    <span class="text-2xl font-bold ">1</span>
                                    <span class=" font-medium"><?php echo $match["club2_name"] ?></span>
                                    <img src=<?php echo isset($match["club2_logo"]) ?  $match["club2_logo"] : " http://efoot/logo?file=img-placeholder.png&dir=image_placeholder" ?> alt="Raja CA" class="w-12 h-12 rounded-full object-cover">
                                </div>
                                <!-- Rest of the match card structure remains the same -->
                            </div>
                            <div class="mt-2 text-sm text-gray-400">
                                <?php echo "Date: " . $match[GameMatch::$date] . "| Time: " . $match[GameMatch::$time] . " | Stadium: " . $match["stadium_name"] ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="flex-col space-y-6 mb-4">
        <div class="flex items-center justify-between mb-4 hover:bg-green-100 transition-colors p-2 rounded-lg cursor-pointer" onclick="toggleSection('FinishedSection')">
            <div class="text-xl font-semibold text-purple-500 "> Finished Matches</div>
            <svg
                id="icon-FinishedSection"
                style="transition: transform 0.3s ease-in-out;transform: rotate(180deg);"
                class="w-6 h-6 text-green-800 transform transition-transform duration-300 ease-in-out"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 9l-7 7-7-7" />
            </svg>

        </div>
        <div id="FinishedSection"
            style="max-height: 1000px;transition: max-height 0.5s ease-in-out;overflow: hidden;"
            class="flex-col space-y-4">
            <?php if (empty($finishedMatches)) : ?>
                <div class="bg-white  rounded-lg shadow-sm border border-green-100 overflow-hidden">
                    <div class="p-8 flex flex-col items-center justify-center">
                        <h3 class="text-lg font-medium text-gray-100 mb-2">No Matches Found</h3>
                        <p class="text-gray-100 text-center max-w-md">
                            There are currently no matches available for this selection. Please check back later.
                        </p>
                    </div>
                </div>
            <?php endif; ?>
            <?php foreach ($finishedMatches as $match) : ?>
                <div class=" relative group:">
                    <div class="bg-white rounded-xl shadow-sm border border-green-100 p-6 group-hover:blur-sm ">
                        <h2 class="text-xl font-semibold  mb-4"> Round: <?php echo $match[GameMatch::$round] ?></h2>
                        <div class="space-y-4">
                            <div class="border border-green-100 rounded-lg p-4 ">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4 flex-1">
                                        <img src=<?php echo isset($match["club1_logo"]) ?  $match["club1_logo"] : " http://efoot/logo?file=img-placeholder.png&dir=image_placeholder" ?> alt="Wydad AC" class="w-12 h-12 rounded-full object-cover">
                                        <span class="font-medium"><?php echo $match["club1_name"] ?></span>
                                        <span class="text-2xl font-bold ">2</span>
                                    </div>
                                    <div class="px-4 py-1 rounded bg-gray-100 text-gray-800">
                                        VS
                                    </div>
                                    <div class="flex items-center space-x-4 flex-1 justify-end">
                                        <span class="text-2xl font-bold ">1</span>
                                        <span class=" font-medium"><?php echo $match["club2_name"] ?></span>
                                        <img src=<?php echo isset($match["club2_logo"]) ?  $match["club2_logo"] : " http://efoot/logo?file=img-placeholder.png&dir=image_placeholder" ?> alt="Raja CA" class="w-12 h-12 rounded-full object-cover">
                                    </div>
                                    <!-- Rest of the match card structure remains the same -->
                                </div>
                                <div class="mt-2 text-sm text-gray-400">
                                    <?php echo "Date: " . $match[GameMatch::$date] . "| Time: " . $match[GameMatch::$time] . " | Stadium: " . $match["stadium_name"] ?>
                                </div>
                            </div>
                        </div>
                        <!-- Hover action buttons - hidden by default, shown on hover -->
                        <div class="absolute inset-0 flex items-center justify-center gap-4   group-hover:opacity-100 transition-opacity duration-300" >
                            <button class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors shadow-md">
                                Edit Match
                            </button>
                            <button class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition-colors shadow-md">
                                Affect Players
                            </button>
                            <button class="px-4 py-2 bg-purple-500 text-white rounded-md hover:bg-purple-600 transition-colors shadow-md">
                                Affect Referees
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>
<script>
    function toggleSection(id) {
        const section = document.getElementById(id);
        const icon = document.getElementById('icon-' + id);
        if (section.style.maxHeight && section.style.maxHeight !== '0px') {
            section.style.maxHeight = '0px';
            icon.style.transform = 'rotate(0deg)';
        } else {
            section.style.maxHeight = section.scrollHeight + 'px';
            icon.style.transform = 'rotate(180deg)';
        }
    }
</script>

<!-- Add/Edit Match Modal -->
<?php include __DIR__ . '/Add_EditMatchModal.php'; ?>