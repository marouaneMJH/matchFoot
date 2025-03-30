<?php
require_once __DIR__ . '/../../../controller/ClubController.php';
require_once __DIR__ . '/../../../controller/StadiumController.php';
require_once __DIR__ . '/../../../controller/GameMatchController.php';
require_once __DIR__ . '/../../../controller/RefereeController.php';
require_once __DIR__ . '/../../../controller/TournamentController.php';
session_start();
// var_dump($_SESSION);
// die();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
  
   
    GameMatchController::store();
}else{
    $tournament_id = $_SESSION['tournament_id'];

    $gameMatches = GameMatchController::indexByTournament($tournament_id);
    $tournament = TournamentController::getTournamentById($tournament_id);
    // var_dump($tournament);
    // die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournament Management</title>
    <link rel="stylesheet" type="text/css" href="../../styles/output.css">
    <style>
        .green-gradient {
            background: linear-gradient(135deg, #15803d 0%, #22c55e 100%);
        }

        .tab-active {
            border-bottom: 2px solid #15803d;
            color: #15803d;
        }

        .nav-item-active {
            background-color: rgba(34, 197, 94, 0.2);
            /* Light green background */
            border-left: 4px solid #22c55e;
            /* Green border */
        }
    </style>

    </style>
</head>

<body class="bg-green-50 min-h-screen">
    <div class="flex h-screen bg-green-50">
        <?php include __DIR__ . '/SideBar.php'; ?>

        <div class="flex-1 overflow-auto ml-72">
            <div class="p-8">
                <!-- Header Section -->
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-green-900"><?php echo $tournament[Tournament::$name] ?></h1>
                        <p class="text-green-600 mt-1">Moroccan Professional Football League</p>
                    </div>

                    <button onclick="openAddMatchModal()"
                        class="green-gradient hover:bg-green-800 text-white px-6 py-2.5 rounded-lg flex items-center gap-2 shadow-lg shadow-green-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add New Match
                    </button>
                </div>

                <!-- Tabs -->
                <div class="mb-6">
                    <div class="border-b border-green-200">
                        <nav class="flex space-x-8">
                            <button onclick="switchTab('matches')" class="tab-active px-4 py-2 text-sm font-medium">
                                Matches
                            </button>
                            <button onclick="switchTab('standings')" class="px-4 py-2 text-sm font-medium text-green-600 hover:text-green-800">
                                Standings
                            </button>
                            <!-- Add this after the existing tabs in the nav section -->
                            <button onclick="switchTab('clubs')" class="px-4 py-2 text-sm font-medium text-green-600 hover:text-green-800">
                                Clubs
                            </button>

                            <button onclick="switchTab('news')" class="px-4 py-2 text-sm font-medium text-green-600 hover:text-green-800">
                                News
                            </button>

                        </nav>
                    </div>
                </div>

                <!-- Matches Tab Content -->
                <?php include __DIR__ . '/MatchTabContent.php'; ?>

                <!-- Standings Tab Content -->
                <?php include __DIR__ . '/StandingsTabContent.php'; ?>

            </div>
            <!-- Clubs Tab Content -->
            <?php include __DIR__ . '/ClubTabContent.php'; ?>

           

                <!-- News List -->
              <?php include __DIR__ . '/NewsTabContent.php'; ?>

            
           

        </div>
    </div>

 

    <script>
        function openAddMatchModal() {
            const modal = document.getElementById('matchModal');
            const scoreSection = document.getElementById('scoreSection');
            scoreSection.classList.add('hidden');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeMatchModal() {
            const modal = document.getElementById('matchModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function editMatch(matchId) {
            const modal = document.getElementById('matchModal');
            const scoreSection = document.getElementById('scoreSection');
            scoreSection.classList.remove('hidden');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            // Add logic to populate form with match data
        }

        function switchTab(tab) {
            const matchesTab = document.getElementById('matchesTab');
            const standingsTab = document.getElementById('standingsTab');
            const clubsTab = document.getElementById('clubsTab');
            const tabs = document.querySelectorAll('nav button');

            tabs.forEach(t => t.classList.remove('tab-active'));

            // Hide all tabs
            matchesTab.classList.add('hidden');
            standingsTab.classList.add('hidden');
            clubsTab.classList.add('hidden');

            // Show selected tab
            if (tab === 'matches') {
                matchesTab.classList.remove('hidden');
                tabs[0].classList.add('tab-active');
            } else if (tab === 'standings') {
                standingsTab.classList.remove('hidden');
                tabs[1].classList.add('tab-active');
            } else if (tab === 'clubs') {
                clubsTab.classList.remove('hidden');
                tabs[2].classList.add('tab-active');
            }
        }

        // Update your switchTab function to include the news tab
        function switchTab(tab) {
            const matchesTab = document.getElementById('matchesTab');
            const standingsTab = document.getElementById('standingsTab');
            const clubsTab = document.getElementById('clubsTab');
            const newsTab = document.getElementById('newsTab');
            const tabs = document.querySelectorAll('nav button');

            tabs.forEach(t => t.classList.remove('tab-active'));

            // Hide all tabs
            matchesTab.classList.add('hidden');
            standingsTab.classList.add('hidden');
            clubsTab.classList.add('hidden');
            newsTab.classList.add('hidden');

            // Show selected tab
            if (tab === 'matches') {
                matchesTab.classList.remove('hidden');
                tabs[0].classList.add('tab-active');
            } else if (tab === 'standings') {
                standingsTab.classList.remove('hidden');
                tabs[1].classList.add('tab-active');
            } else if (tab === 'clubs') {
                clubsTab.classList.remove('hidden');
                tabs[2].classList.add('tab-active');
            } else if (tab === 'news') {
                newsTab.classList.remove('hidden');
                tabs[3].classList.add('tab-active');
            }
        }

        // News modal functions
        function openAddNewsModal() {
            const modal = document.getElementById('newsModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeNewsModal() {
            const modal = document.getElementById('newsModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Optional: Add rich text editor initialization if you want to use one
        document.addEventListener('DOMContentLoaded', function() {
            // You can initialize a rich text editor here for the news content
            // Example with TinyMCE or other editor of your choice
        });

        // Optional: Preview image before upload
        document.querySelector('input[type="file"]').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // You can show a preview of the image here if needed
                };
                reader.readAsDataURL(file);
            }
        });


        function openAddClubModal() {
            const modal = document.getElementById('addClubModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeAddClubModal() {
            const modal = document.getElementById('addClubModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</body>

</html>