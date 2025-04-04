<?php
require_once __DIR__ . '/../../../controller/GameMatchController.php';
require_once __DIR__ . '/../../../controller/GoalController.php';
require_once __DIR__ . '/../../../controller/VoteController.php';  // Add this line


$matches = GameMatchController::indexAll();
$goals = [];
$liveMatches = $upComingMatches = $finishedMatches = [];


foreach ($matches as $match) {
    if ($match['status'] == 'Upcoming') {
        $upComingMatches[] = $match;
    } elseif ($match['status'] == 'Finished') {

        $finishedMatches[] = $match;
    } else {

        $liveMatches[] = $match;
    }
}


?>

<div id="accueil" class="container mx-auto px-4 py-8 overflow-auto w-[95%] h-[80vh] bg-green-50">
    <section class="mb-12">
        <h2 class="text-2xl font-bold mb-6 text-green-800">Match en direct</h2>
        <?php if (count($liveMatches) > 0): ?>
            <?php foreach ($liveMatches as $liveMatch): ?>
                <a href="./MatchLineup.php?match_id=<?php echo $liveMatch['id']; ?>" class="block hover:shadow-lg transition duration-300">
                    <section class="bg-white rounded-lg shadow-md p-6 mb-4 border-l-4 border-green-600">
                        <div class="grid grid-cols-3 gap-4 items-center">
                            <div class="flex items-center space-x-4">
                                <img src="../../assets/images/equipes_logo/raja_logo.jpeg" alt="RCA" class="w-12 h-12 rounded-full">
                                <span class="font-semibold text-lg"><?php echo $liveMatch['club1_name'] ?></span>
                            </div>
                            <div class="text-center">
                                <div class="flex justify-center items-center space-x-4">
                                    <span class="text-2xl font-bold text-green-700"><?php echo $liveMatch["homeScore"] ?></span>
                                    <div class="p-5 border-4 border-green-600 text-green-600 rounded-full flex flex-col items-center justify-center w-20 h-20 animate-pulse">
                                        <span class="text-sm font-bold"><?php echo $liveMatch["minute"] . "'m" ?></span>
                                        <span class="text-xs font-bold">LIVE</span>
                                    </div>
                                    <span class="text-2xl font-bold text-green-700"><?php echo $liveMatch["awayScore"] ?></span>
                                </div>
                                <div class="mt-4 flex items-center justify-center space-x-4 text-sm text-green-700">
                                    <div class="flex items-center">
                                        <img src="../../assets/images/equipes_logo/stadium image.jpeg" alt="Stadium" class="w-4 h-4 mr-2">
                                        <span><?php echo $liveMatch["stadium_name"] ?></span>
                                    </div>
                                    <div class="flex items-center">
                                        <img src="../../assets/images/equipes_logo/whistle.png" alt="Referee" class="w-4 h-4 mr-2">
                                        <span><?php echo $liveMatch["referee_name"] . " " . $liveMatch["referee_surname"] ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-end space-x-4">
                                <span class="font-semibold text-lg"><?php echo $liveMatch['club2_name'] ?></span>
                                <img src="../../assets/images/equipes_logo/WYDAD_logo.png" alt="WAC" class="w-12 h-12 rounded-full">
                            </div>
                        </div>
                    </section>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="bg-white rounded-lg p-6 text-center border border-green-200">
                <span class="block text-3xl font-bold text-green-400">0</span>
                <span class="text-green-600">Matchs en direct</span>
            </div>
        <?php endif; ?>
    </section>

    <section class="mb-12">
        <h2 class="text-2xl font-bold mb-6 text-green-800">Matchs à venir</h2>
        <?php if (count($upComingMatches) > 0): ?>
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($upComingMatches as $upcomingMatch): 
                    $matchVotes = VoteController::getMatchVotes($upcomingMatch['id']);
                    $hasVoted = isset($_SESSION['user_id']) ? Vote::hasUserVoted($_SESSION['user_id'], $upcomingMatch['id']) : false;
                ?>
                    <div class="bg-white rounded-lg shadow-md p-6 hover:border-green-500 border-2 border-transparent relative">
                        <div class="absolute top-0 right-0 bg-green-100 text-green-800 px-3 py-1 rounded-bl-lg rounded-tr-lg text-sm font-semibold">
                            À venir
                        </div>
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center space-x-3">
                                <img src="../../assets/images/equipes_logo/raja_logo.jpeg" alt="RCA" class="w-12 h-12 rounded-full border-2 border-green-200">
                                <span class="font-semibold text-gray-800"><?php echo $upcomingMatch['club1_nickname'] ?></span>
                            </div>
                            <div class="text-2xl font-bold text-green-600">VS</div>
                            <div class="flex items-center space-x-3">
                                <span class="font-semibold text-gray-800"><?php echo $upcomingMatch['club2_nickname'] ?></span>
                                <img src="../../assets/images/equipes_logo/WYDAD_logo.png" alt="WAC" class="w-12 h-12 rounded-full border-2 border-green-200">
                            </div>
                        </div>
                        
                        <!-- Voting Section -->
                        <div class="mt-4 p-4 bg-green-50 rounded-lg">
                            <div class="text-center mb-4">
                                <span class="text-sm font-semibold">Pronostics des fans:</span>
                                <div class="flex justify-between text-sm mt-2">
                                    <span><?php echo $matchVotes['home_percentage'] ?>% <?php echo $upcomingMatch['club1_nickname'] ?></span>
                                    <span><?php echo $matchVotes['draw_percentage'] ?>% Nul</span>
                                    <span><?php echo $matchVotes['away_percentage'] ?>% <?php echo $upcomingMatch['club2_nickname'] ?></span>
                                </div>
                            </div>
                            
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <?php if (!$hasVoted): ?>
                                    <div class="flex justify-center space-x-2">
                                        <button onclick="submitVote(<?php echo $upcomingMatch['id'] ?>, 1)" 
                                                class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                            Domicile
                                        </button>
                                        <button onclick="submitVote(<?php echo $upcomingMatch['id'] ?>, 0)" 
                                                class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-700">
                                            Nul
                                        </button>
                                        <button onclick="submitVote(<?php echo $upcomingMatch['id'] ?>, 2)" 
                                                class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                                            Extérieur
                                        </button>
                                    </div>
                                <?php else: ?>
                                    <div class="text-center text-green-600 font-semibold">
                                        Vous avez déjà voté pour ce match
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="text-center text-gray-600">
                                    <a href="login.php" class="text-green-600 hover:underline">Connectez-vous</a> pour voter
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Existing match details -->
                        <div class="text-center p-4">
                            <span class="block text-lg font-bold text-green-700"><?php echo $upcomingMatch['time'] ?></span>
                            <span class="text-sm text-green-600"><?php echo $upcomingMatch['dateLabel'] ?></span>
                        </div>
                        <div class="mt-4 text-center text-sm text-gray-600 flex items-center justify-center">
                            <img src="../../assets/images/equipes_logo/stadium image.jpeg" alt="Stadium" class="w-4 h-4 mr-2">
                            <span><?php echo $upcomingMatch['stadium_name'] ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>

    <section>
        <h2 class="text-2xl font-bold mb-6 text-green-800">Résultats précédents</h2>
        <?php if (count($finishedMatches) > 0): ?>
            <div class="space-y-4">
                <?php foreach ($finishedMatches as $finishedMatch): ?>
                    <a href="./match-details.php" target="_blank" class="block hover:shadow-lg transition duration-300">
                        <div class="bg-white rounded-lg shadow-md p-6 hover:bg-green-50">
                            <div class="grid grid-cols-7 gap-4 items-center">
                                <div class="col-span-2 flex items-center space-x-3">
                                    <img src="../../assets/images/equipes_logo/IR tanger_logo.png" alt="AS FAR" class="w-12 h-12 rounded-full border-2 border-green-200">
                                    <div class="flex flex-col">
                                        <span class="font-semibold text-gray-800"><?php echo $finishedMatch['club1_nickname'] ?></span>
                                        <span class="text-sm text-green-600 font-bold"><?php echo $finishedMatch['homeScore'] ?></span>
                                    </div>
                                </div>
                                <div class="col-span-3 text-center">
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <span class="text-sm font-semibold text-green-700">TERMINÉ</span>
                                        <div class="mt-2 text-xs text-gray-600"><?php echo $finishedMatch["dateLabel"]?></div>
                                    </div>
                                    <div class="mt-2 text-sm text-gray-600 flex items-center justify-center">
                                        <img src="../../assets/images/equipes_logo/stadium image.jpeg" alt="Stadium" class="w-4 h-4 mr-2">
                                        <span><?php echo $finishedMatch["stadium_name"]?></span>
                                    </div>
                                </div>
                                <div class="col-span-2 flex items-center justify-end space-x-3">
                                    <div class="flex flex-col items-end">
                                        <span class="font-semibold text-gray-800">SCCM</span>
                                        <span class="text-sm text-green-600 font-bold"><?php echo $finishedMatch['awayScore'] ?></span>
                                    </div>
                                    <img src="../../assets/images/equipes_logo/SCCM_logo.png" alt="RS Berkane" class="w-12 h-12 rounded-full border-2 border-green-200">
                                </div>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</div>

<!-- Add this before closing body tag -->
<script>
function submitVote(matchId, vote) {
    fetch('../../../controller/vote_handler.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `match_id=${matchId}&vote=${vote}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Vote enregistré avec succès!');
            location.reload();
        } else {
            alert(data.error || 'Erreur lors du vote');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Une erreur est survenue');
    });
}
</script>