<?php require_once __DIR__ . '/../../../controller/TournamentController.php';



if (!isset($_SESSION['admin_id'])) {
    header('Location: ../auth_page/Login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tournament_id'])) {
    $_SESSION['tournament_id'] = $_POST['tournament_id'];
} else if (!isset($_SESSION['tournament_id'])) {
    header('Location: ./Dashboard.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/output.css">
    <title>Tournament Admin Dashboard</title>
</head>

<body>
    <div class="w-72 h-screen bg-gradient-to-b from-green-800 to-green-900 flex flex-col fixed left-0 shadow-xl">
        <!-- Brand Header -->
        <div class="p-6 border-b border-green-700/50">
            <a href="./Dashboard.php" class="flex items-center justify-center space-x-3 group">
                <div class="p-2 bg-green-700 rounded-lg group-hover:bg-green-600 transition-colors duration-200">
                    <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white group-hover:text-green-400 transition-colors duration-200">Tournament Hub</h1>
            </a>
        </div>

        <!-- Admin Profile Section -->
        <div class="p-6 border-b border-green-700/50 flex flex-col items-center">
            <div class="relative group">
                <img
                    src="<?php echo $_SESSION['admin_profile_pic'] ?? 'http://efoot/logo?file=img-placeholder.png&dir=image_placeholder'; ?>"
                    alt="Admin Profile"
                    class="w-24 h-24 rounded-full object-cover border-4 border-green-400 shadow-xl group-hover:border-green-300 transition-all duration-300">
                <div class="absolute bottom-0 right-0 bg-green-400 w-5 h-5 rounded-full border-2 border-green-900 shadow-lg"></div>
            </div>
            <h2 class="mt-4 text-lg font-semibold text-white">Admin Tournoie</h2>
            <p class="text-sm text-green-300">Tournament Administrator</p>
        </div>

        <!-- Tournament Selection -->
        <div class="p-4 border-b border-green-700/50">
            <div class="relative">
                <?php $tournaments = TournamentController::getTournamentsByAdminId($_SESSION['admin_id']); ?>
                <form action="" method="POST">
                    <select id="tournamentSelector"
                    default="<?php echo $_SESSION['tournament_id'] ?? ''; ?>"
                    onchange="this.form.submit()"
                    name="tournament_id"
                        class="w-full p-2.5 bg-green-700 text-white rounded-lg border border-green-600 focus:outline-none focus:border-green-400 focus:ring-1 focus:ring-green-400">
                        <option value="" disabled selected>Select Tournament</option>
                        <?php foreach ($tournaments as $tournament): ?>
                            <option value="<?php echo $tournament['id']; ?>">
                                <?php echo htmlspecialchars($tournament[Tournament::$name]); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>
        </div>

        <!-- Tournament Management Menu -->
        <nav class="flex-1 overflow-y-auto py-4 px-3">
            <div class="space-y-2">
                <!-- Overview Section -->
                <div class="mb-6">
                    <h3 class="px-4 py-2 text-xs font-semibold text-green-400 uppercase tracking-wider">
                        Tournament Overview
                    </h3>
                    <div class="space-y-1">
                        <a href="./Dashboard.php"
                            class="flex items-center px-4 py-3 text-green-100 hover:bg-green-700/50 rounded-lg transition-all duration-200 group">
                            <svg class="w-5 h-5 mr-3 text-green-400 group-hover:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            <span class="group-hover:translate-x-1 transition-transform duration-200">Dashboard</span>
                        </a>
                    </div>
                </div>

                <!-- Match Management -->
                <div class="mb-6">
                    <h3 class="px-4 py-2 text-xs font-semibold text-green-400 uppercase tracking-wider">
                        Match Management
                    </h3>
                    <div class="space-y-1">
                        <a href="./TournamentInfos.php"
                            class="flex items-center px-4 py-3 text-green-100 hover:bg-green-700/50 rounded-lg transition-all duration-200 group">
                            <svg class="w-5 h-5 mr-3 text-green-400 group-hover:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="group-hover:translate-x-1 transition-transform duration-200">Match Schedule</span>
                        </a>
                    </div>
                </div>

                <!-- Team Management -->
                <div class="mb-6">
                    <h3 class="px-4 py-2 text-xs font-semibold text-green-400 uppercase tracking-wider">
                        Team Management
                    </h3>
                    <div class="space-y-1">
                        <a href="./Teams.php"
                            class="flex items-center px-4 py-3 text-green-100 hover:bg-green-700/50 rounded-lg transition-all duration-200 group">
                            <svg class="w-5 h-5 mr-3 text-green-400 group-hover:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="group-hover:translate-x-1 transition-transform duration-200">Participating Teams</span>
                        </a>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="mb-6">
                    <h3 class="px-4 py-2 text-xs font-semibold text-green-400 uppercase tracking-wider">
                        Statistics
                    </h3>
                    <div class="space-y-1">
                        <a href="./Statistics.php"
                            class="flex items-center px-4 py-3 text-green-100 hover:bg-green-700/50 rounded-lg transition-all duration-200 group">
                            <svg class="w-5 h-5 mr-3 text-green-400 group-hover:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <span class="group-hover:translate-x-1 transition-transform duration-200">Tournament Stats</span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Logout Section -->
        <div class="mt-auto border-t border-green-700/50 p-4">
            <a href="../auth_page/Login.php"
                class="flex items-center px-4 py-3 text-red-300 hover:bg-red-900/20 hover:text-red-200 rounded-lg transition-all duration-200 group">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span class="font-medium group-hover:translate-x-1 transition-transform duration-200">Logout</span>
            </a>
        </div>
    </div>

    <script>
        // Show tournament menu by default
        document.addEventListener('DOMContentLoaded', function() {
            // Handle tournament selection
            const tournamentSelector = document.getElementById('tournamentSelector');
            tournamentSelector.addEventListener('change', function() {
                const selectedValue = this.value;
                if (selectedValue) {
                    // Store selected tournament in session/local storage
                    localStorage.setItem('selectedTournament', selectedValue);
                    // You can add additional logic here to load tournament-specific data
                }
            });

            // Check for previously selected tournament
            const savedTournament = localStorage.getItem('selectedTournament');
            if (savedTournament) {
                tournamentSelector.value = savedTournament;
            }

            // Add active state to current page link
            const currentPage = window.location.pathname;
            const navLinks = document.querySelectorAll('nav a');

            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPage) {
                    link.classList.add('bg-green-700/50');
                }
            });
        });
        const tournamentSelector = document.getElementById('tournamentSelector');
        tournamentSelector.addEventListener('change', function() {
            const selectedValue = this.value;
            if (selectedValue) {
                // Store selected tournament in session/local storage
                localStorage.setItem('selectedTournament', selectedValue);
                // You can add additional logic here to load tournament-specific data
            }
        });
    </script>

</body>

</html>