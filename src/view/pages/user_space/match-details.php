<?php
require_once __DIR__ . '/../../../controller/GameMatchController.php';
require_once __DIR__ . '/../../../controller/LineupController.php';
require_once __DIR__ . '/../../../controller/GoalController.php';
require_once __DIR__ . '/../../../controller/CardController.php';
require_once __DIR__ . '/../../../controller/SubstitutionController.php';

if (!isset($_GET['match_id'])) {
    header("Location: ./Match.php");
    exit;
}

$matchId = $_GET['match_id'];
$match = GameMatchController::getGameMatchById($matchId);
$lineups = LineupController::getAllLineupDataByMatchId($matchId);
$goals = GoalController::getGoalsByMatchId($matchId);
$cards = CardController::getCardsByMatchId($matchId);
$substitutions = SubstitutionController::getSubstitutionsByMatchId($matchId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Match Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-green-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Back button -->
        <a href="./Accueil.php" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors mb-6">
            <i class="fas fa-arrow-left mr-2"></i> Back to Matches
        </a>

        <!-- Match Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-8">
                    <img src="../../assets/images/equipes_logo/raja_logo.jpeg" alt="RCA" class="w-16 h-16 rounded-full">
                    <div class="text-2xl font-bold">Raja Club Athletic</div>
                </div>
                <div class="text-center">
                    <div class="flex items-center space-x-4">
                        <span class="text-3xl font-bold">2</span>
                        <div class="px-4 py-2 bg-green-100 text-green-800 rounded-lg animate-pulse">
                            65'
                        </div>
                        <span class="text-3xl font-bold">1</span>
                    </div>
                    <div class="text-sm text-gray-500 mt-2">Stade Mohammed V</div>
                </div>
                <div class="flex items-center space-x-8">
                    <div class="text-2xl font-bold">Wydad Athletic Club</div>
                    <img src="../../assets/images/equipes_logo/WYDAD_logo.png" alt="WAC" class="w-16 h-16 rounded-full">
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Lineups Section -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold mb-4">Match Lineups</h2>
                    
                    <!-- Soccer Field Visualization -->
                    <div id="soccer-field" class="relative bg-green-600 rounded-lg aspect-[3/2] w-full mb-8">
                        <!-- Field markings -->
                        <div class="absolute inset-0 flex flex-col">
                            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-32 h-32 border-2 border-white rounded-full"></div>
                            <div class="absolute top-1/2 left-0 right-0 h-0.5 bg-white"></div>
                            <div class="absolute top-0 left-1/4 right-1/4 h-24 border-b-2 border-l-2 border-r-2 border-white"></div>
                            <div class="absolute bottom-0 left-1/4 right-1/4 h-24 border-t-2 border-l-2 border-r-2 border-white"></div>
                            <div class="absolute top-0 left-1/3 right-1/3 h-10 border-b-2 border-l-2 border-r-2 border-white"></div>
                            <div class="absolute bottom-0 left-1/3 right-1/3 h-10 border-t-2 border-l-2 border-r-2 border-white"></div>
                        </div>
                    </div>

                    <!-- Team Lineups -->
                    <div class="grid grid-cols-2 gap-8">
                        <!-- Home Team -->
                        <div>
                            <h3 class="font-bold text-lg mb-3 text-green-800">Raja Club Athletic</h3>
                            <div id="home-lineup" class="space-y-2"></div>
                        </div>

                        <!-- Away Team -->
                        <div>
                            <h3 class="font-bold text-lg mb-3 text-green-800">Wydad Athletic Club</h3>
                            <div id="away-lineup" class="space-y-2"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Match Events Timeline -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold mb-4">Match Events</h2>
                <div class="space-y-4">
                    <div class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50">
                        <span class="text-sm font-semibold text-gray-500">23'</span>
                        <i class="fas fa-futbol text-green-600"></i>
                        <span>Hamza Sahel (Raja Club Athletic)</span>
                    </div>
                    <div class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50">
                        <span class="text-sm font-semibold text-gray-500">35'</span>
                        <i class="fas fa-square text-yellow-500"></i>
                        <span>Yahya Jabrane (Wydad Athletic Club)</span>
                    </div>
                    <div class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50">
                        <span class="text-sm font-semibold text-gray-500">45'</span>
                        <i class="fas fa-futbol text-green-600"></i>
                        <span>Bouly Junior (Wydad Athletic Club)</span>
                    </div>
                    <div class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50">
                        <span class="text-sm font-semibold text-gray-500">58'</span>
                        <i class="fas fa-exchange-alt text-blue-500"></i>
                        <span>Mohamed Zrida ↔ Mahmoud Benhalib</span>
                    </div>
                    <div class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50">
                        <span class="text-sm font-semibold text-gray-500">62'</span>
                        <i class="fas fa-futbol text-green-600"></i>
                        <span>Hamza Sahel (Raja Club Athletic)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Formation positions mapping
        const formationPositions = {
            '4-3-3': {
                'home': {
                    'GK': [50, 95],
                    'LB': [20, 80],
                    'CB': [40, 80],
                    'CB2': [60, 80],
                    'RB': [80, 80],
                    'CDM': [30, 65],
                    'CM': [50, 65],
                    'CAM': [70, 65],
                    'LW': [20, 40],
                    'ST': [50, 40],
                    'RW': [80, 40]
                },
                'away': {
                    'GK': [50, 5],
                    'LB': [20, 20],
                    'CB': [40, 20],
                    'CB2': [60, 20],
                    'RB': [80, 20],
                    'CDM': [30, 35],
                    'CM': [50, 35],
                    'CAM': [70, 35],
                    'LW': [20, 60],
                    'ST': [50, 60],
                    'RW': [80, 60]
                }
            },
            '4-4-2': {
                'home': {
                    'GK': [50, 95],
                    'LB': [20, 80],
                    'CB': [40, 80],
                    'CB2': [60, 80],
                    'RB': [80, 80],
                    'LM': [20, 60],
                    'CM': [40, 60],
                    'CM2': [60, 60],
                    'RM': [80, 60],
                    'ST': [40, 40],
                    'ST2': [60, 40]
                },
                'away': {
                    'GK': [50, 5],
                    'LB': [20, 20],
                    'CB': [40, 20],
                    'CB2': [60, 20],
                    'RB': [80, 20],
                    'LM': [20, 40],
                    'CM': [40, 40],
                    'CM2': [60, 40],
                    'RM': [80, 40],
                    'ST': [40, 60],
                    'ST2': [60, 60]
                }
            },
            '3-5-2': {
                'home': {
                    'GK': [50, 95],
                    'CB': [30, 80],
                    'CB2': [50, 80],
                    'CB3': [70, 80],
                    'LWB': [15, 65],
                    'CDM': [30, 65],
                    'CM': [50, 65],
                    'CAM': [70, 65],
                    'RWB': [85, 65],
                    'ST': [40, 40],
                    'ST2': [60, 40]
                },
                'away': {
                    'GK': [50, 5],
                    'CB': [30, 20],
                    'CB2': [50, 20],
                    'CB3': [70, 20],
                    'LWB': [15, 35],
                    'CDM': [30, 35],
                    'CM': [50, 35],
                    'CAM': [70, 35],
                    'RWB': [85, 35],
                    'ST': [40, 60],
                    'ST2': [60, 60]
                }
            },
            '5-3-2': {
                'home': {
                    'GK': [50, 95],
                    'LWB': [10, 80],
                    'CB': [30, 80],
                    'CB2': [50, 80],
                    'CB3': [70, 80],
                    'RWB': [90, 80],
                    'CDM': [30, 60],
                    'CM': [50, 60],
                    'CAM': [70, 60],
                    'ST': [40, 40],
                    'ST2': [60, 40]
                },
                'away': {
                    'GK': [50, 5],
                    'LWB': [10, 20],
                    'CB': [30, 20],
                    'CB2': [50, 20],
                    'CB3': [70, 20],
                    'RWB': [90, 20],
                    'CDM': [30, 40],
                    'CM': [50, 40],
                    'CAM': [70, 40],
                    'ST': [40, 60],
                    'ST2': [60, 60]
                }
            },
            '4-2-3-1': {
                'home': {
                    'GK': [50, 95],
                    'LB': [20, 80],
                    'CB': [40, 80],
                    'CB2': [60, 80],
                    'RB': [80, 80],
                    'CDM': [35, 65],
                    'CDM2': [65, 65],
                    'LM': [20, 50],
                    'CAM': [50, 50],
                    'RM': [80, 50],
                    'ST': [50, 35]
                },
                'away': {
                    'GK': [50, 5],
                    'LB': [20, 20],
                    'CB': [40, 20],
                    'CB2': [60, 20],
                    'RB': [80, 20],
                    'CDM': [35, 35],
                    'CDM2': [65, 35],
                    'LM': [20, 50],
                    'CAM': [50, 50],
                    'RM': [80, 50],
                    'ST': [50, 65]
                }
            },
            '3-4-3': {
                'home': {
                    'GK': [50, 95],
                    'CB': [30, 80],
                    'CB2': [50, 80],
                    'CB3': [70, 80],
                    'LM': [15, 60],
                    'CM': [35, 60],
                    'CM2': [65, 60],
                    'RM': [85, 60],
                    'LW': [25, 40],
                    'ST': [50, 40],
                    'RW': [75, 40]
                },
                'away': {
                    'GK': [50, 5],
                    'CB': [30, 20],
                    'CB2': [50, 20],
                    'CB3': [70, 20],
                    'LM': [15, 40],
                    'CM': [35, 40],
                    'CM2': [65, 40],
                    'RM': [85, 40],
                    'LW': [25, 60],
                    'ST': [50, 60],
                    'RW': [75, 60]
                }
            }
        };

        function updateFieldPositions(formation, team) {
            const positions = formationPositions[formation][team];
            const players = document.querySelectorAll(`.player-dot.${team}-team`);
            
            players.forEach((player, index) => {
                const position = Object.keys(positions)[index];
                const [x, y] = positions[position];
                player.style.left = `${x}%`;
                player.style.top = `${y}%`;
            });
        }
        
        // Function to create player dot
        function createPlayerDot(player, team) {
            const position = formationPositions[staticMatchData[team].formation][team][player.position];
            if (!position) return null;

            const dot = document.createElement('div');
            dot.className = 'absolute player-dot';
            dot.style.left = `${position[0]}%`;
            dot.style.top = `${position[1]}%`;
            dot.innerHTML = `
                <div class="w-12 h-12 rounded-full ${team === 'homeTeam' ? 'bg-blue-500' : 'bg-red-500'} flex items-center justify-center text-white font-bold shadow-lg transform hover:scale-110 transition-transform">
                    <div class="text-center">
                        <div class="text-sm">${player.number}</div>
                        <div class="text-xs">${player.position}</div>
                    </div>
                </div>
            `;
            return dot;
        }

        function updateLineupList(players, containerId) {
            const container = document.getElementById(containerId);
            container.innerHTML = '';
            players.forEach(player => {
                const div = document.createElement('div');
                div.className = 'flex items-center space-x-2 font-semibold';
                div.innerHTML = `
                    <span class="w-6">${player.number}</span>
                    <span>${player.name}</span>
                `;
                container.appendChild(div);
            });
        }

        function initializeField() {
            const field = document.getElementById('soccer-field');
            if (!field) return;

            // Clear existing players
            const existingPlayers = field.querySelectorAll('.player-dot');
            existingPlayers.forEach(player => player.remove());

            // Add home team players
            staticMatchData.homeTeam.players.forEach(player => {
                const dot = createPlayerDot(player, 'homeTeam');
                if (dot) field.appendChild(dot);
            });

            // Add away team players
            staticMatchData.awayTeam.players.forEach(player => {
                const dot = createPlayerDot(player, 'awayTeam');
                if (dot) field.appendChild(dot);
            });

            // Update lineup lists
            updateLineupList(staticMatchData.homeTeam.players, 'home-lineup');
            updateLineupList(staticMatchData.awayTeam.players, 'away-lineup');

            // Add formation label
            const formationLabel = document.createElement('div');
            formationLabel.className = 'absolute top-2 right-2 bg-black/50 text-white px-2 py-1 rounded text-sm';
            formationLabel.textContent = `${staticMatchData.homeTeam.formation} vs ${staticMatchData.awayTeam.formation}`;
            field.appendChild(formationLabel);
        }

        document.addEventListener('DOMContentLoaded', initializeField);
    </script>
</body>
</html>
