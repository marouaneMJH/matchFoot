<?php 
require_once __DIR__ . '/../../../controller/PlayerController.php';
require_once __DIR__ . '/../../../controller/RefereeController.php';

if(!isset($_GET['match_id'])) {
    header('Location: TournamentInfos.php'); // Redirect if match ID is not set
    exit;
}
$match_id = $_GET['match_id'];
$homeTeamPlayers = PlayerController::getPlayersByMatch($match_id,"home"); // Example team ID for home team
$awayTeamPlayers = PlayerController::getPlayersByMatch($match_id,"away"); // Example team ID for away team
$referees = RefereeController::index();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Match Setup - Player & Referee Assignment</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style type="text/tailwindcss">
@layer components {
  .btn {
    @apply px-4 py-2 rounded-md font-medium transition-colors;
  }
  .btn-primary {
    @apply bg-green-600 text-white hover:bg-green-700;
  }
  .btn-outline {
    @apply border border-gray-300 hover:bg-gray-100;
  }
  .btn-sm {
    @apply px-2 py-1 text-sm;
  }
  .card {
    @apply bg-white rounded-lg shadow-sm border border-gray-100;
  }
  .card-header {
    @apply p-4 border-b border-gray-100;
  }
  .card-body {
    @apply p-4;
  }
  .tab {
    @apply px-4 py-2 font-medium text-gray-600 border-b-2 border-transparent hover:text-gray-800 cursor-pointer;
  }
  .tab.active {
    @apply text-green-600 border-green-600;
  }
  .field-tab {
    @apply px-3 py-1 text-sm font-medium rounded-t-md border border-b-0 cursor-pointer transition-colors;
  }
  .field-tab.active {
    @apply bg-white shadow text-gray-800;
  }
  .field-tab.active.home-tab {
    @apply text-blue-600;
  }
  .field-tab.active.away-tab {
    @apply text-red-600;
  }
  .badge {
    @apply px-2 py-1 text-xs rounded-full font-medium;
  }
  .badge-green {
    @apply bg-green-100 text-green-800;
  }
  .badge-blue {
    @apply bg-blue-100 text-blue-800;
  }
  .badge-red {
    @apply bg-red-100 text-red-800;
  }
  .player-dot {
    @apply w-10 h-10 rounded-full flex items-center justify-center text-white text-xs absolute cursor-pointer;
    transition: all 0.3s ease;
  }
  .player-dot-home {
    @apply bg-blue-500;
  }
  .player-dot-away {
    @apply bg-red-500;
  }
  .position-marker {
    @apply w-8 h-8 rounded-full border-2 border-dashed border-white/50 absolute;
  }
  .position-marker:hover {
    @apply border-white;
  }
  .player-dot.selected {
    @apply ring-2 ring-yellow-400 ring-offset-2 scale-110;
  }
}
</style>
</head>
<body class="bg-gray-50 min-h-screen">
<div class="container mx-auto py-6 px-4">
<!-- Back button -->
<button class="flex items-center text-gray-600 mb-4 hover:text-gray-800">
  <i class="fas fa-arrow-left mr-2"></i> Back to Matches
</button>

<!-- Match header -->
<div class="card mb-6 border-green-100">
  <div class="card-header bg-green-50 flex justify-between items-center">
    <div>
      <h1 class="text-xl font-bold">Match Setup</h1>
      <p class="text-gray-500 text-sm mt-1">
        Raja Club Athletic vs Olympique Club de Khouribga | 2025-04-02 | 06:05:00 | Stade Phosphate
      </p>
    </div>
    <span class="badge badge-green">Round 8</span>
  </div>
</div>

<!-- Tabs -->
<div class="mb-6 border-b border-gray-200">
  <div class="flex">
    <div class="tab active" data-tab="players">
      <i class="fas fa-users mr-2"></i> Players & Formations
    </div>
    <div class="tab" data-tab="referees">
      <i class="fas fa-whistle mr-2"></i> Referees
    </div>
  </div>
</div>

<!-- Tab content -->
<div class="tab-content">
  <!-- Players tab -->
  <div id="players-tab" class="tab-pane active">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Home team players -->
      <div class="card">
        <div class="card-header bg-blue-50">
          <h2 class="text-blue-800 font-bold flex items-center">
            <i class="fas fa-user-circle mr-2"></i> Raja Club Athletic
          </h2>
          <div class="text-sm text-gray-500 mt-1 flex space-x-2">
            <span>Starting: <span id="home-starting-count">0</span>/11 players</span>
            <span>Substitutes: <span id="home-substitute-count">0</span>/7 players</span>
          </div>
        </div>
        <div class="card-body">
          <div class="space-y-2 max-h-[42rem] overflow-y-auto pr-2" id="home-players-list">
            <!-- Home players will be populated here by JavaScript -->
          </div>
        </div>
      </div>
      
      <!-- Field visualization - MADE LARGER -->
      <div class="card col-span-1 lg:col-span-1">
        <div class="card-header bg-green-50 flex justify-between items-center">
          <h2 class="text-green-800 font-bold flex items-center">
            <i class="fas fa-clipboard-list mr-2"></i> Formation
          </h2>
          
          <!-- Team-specific formation selectors -->
          <div class="flex items-center">
            <select id="home-formation-select" class="border border-blue-300 rounded-md px-2 py-1 text-sm bg-blue-50 text-blue-800" style="display: block;">
              <option value="4-3-3">4-3-3</option>
              <option value="4-4-2">4-4-2</option>
              <option value="3-5-2">3-5-2</option>
              <option value="5-3-2">5-3-2</option>
              <option value="4-2-3-1">4-2-3-1</option>
              <option value="3-4-3">3-4-3</option>
            </select>
            <select id="away-formation-select" class="border border-red-300 rounded-md px-2 py-1 text-sm bg-red-50 text-red-800" style="display: none;">
              <option value="4-3-3">4-3-3</option>
              <option value="4-4-2">4-4-2</option>
              <option value="3-5-2">3-5-2</option>
              <option value="5-3-2">5-3-2</option>
              <option value="4-2-3-1">4-2-3-1</option>
              <option value="3-4-3">3-4-3</option>
            </select>
          </div>
        </div>
        <div class="card-body">
          <!-- Field tabs for team lineups -->
          <div class="flex mb-2 ml-1">
            <div class="field-tab home-tab active bg-blue-50 text-blue-600 border-blue-100" data-team="home">
              <i class="fas fa-users mr-1"></i> Home Team Lineup
            </div>
            <div class="field-tab away-tab bg-gray-50 text-gray-500 border-gray-100 ml-1" data-team="away">
              <i class="fas fa-users mr-1"></i> Away Team Lineup
            </div>
          </div>
          
          <!-- Soccer field visualization - MADE LARGER -->
          <div class="relative bg-green-600 rounded-md aspect-[3/2] w-full max-w-[700px] h-[32rem] mx-auto" id="soccer-field">
            <!-- Field markings -->
            <div class="absolute inset-0 flex flex-col">
              <!-- Center circle -->
              <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-32 h-32 border-2 border-white rounded-full"></div>
              
              <!-- Center line -->
              <div class="absolute top-1/2 left-0 right-0 h-0.5 bg-white"></div>
              
              <!-- Penalty areas -->
              <div class="absolute top-0 left-1/4 right-1/4 h-24 border-b-2 border-l-2 border-r-2 border-white"></div>
              <div class="absolute bottom-0 left-1/4 right-1/4 h-24 border-t-2 border-l-2 border-r-2 border-white"></div>
              
              <!-- Goal areas -->
              <div class="absolute top-0 left-1/3 right-1/3 h-10 border-b-2 border-l-2 border-r-2 border-white"></div>
              <div class="absolute bottom-0 left-1/3 right-1/3 h-10 border-t-2 border-l-2 border-r-2 border-white"></div>
            </div>
            
            <!-- Team label for currently viewed team -->
            <div id="team-label" class="absolute top-2 left-2 text-white font-bold text-sm bg-blue-600 px-2 py-1 rounded">
              Home Team Lineup
            </div>
            
            <!-- Formation label -->
            <div id="formation-label" class="absolute top-2 right-2 text-white font-bold text-sm bg-black/50 px-2 py-1 rounded">
              4-3-3
            </div>
            
            <!-- Player positions will be added here by JavaScript -->
            <div id="player-positions"></div>
          </div>
          
          <!-- Position selector -->
          <div class="mt-4 p-3 bg-gray-50 rounded-md" id="position-editor">
            <h4 class="text-sm font-medium mb-2">Player Position Assignment</h4>
            <div class="text-sm text-gray-500 mb-2">
              Select a player from the lists and assign a position
            </div>
            <div id="selected-player-info" class="hidden">
              <div class="flex items-center justify-between mb-2">
                <div>
                  <span class="font-medium" id="edit-player-name"></span>
                  <span class="text-xs text-gray-500" id="edit-player-team"></span>
                </div>
                <button class="text-xs text-red-500" id="remove-from-position">
                  <i class="fas fa-times mr-1"></i> Remove
                </button>
              </div>
              <div class="grid grid-cols-2 gap-2">
                <div>
                  <label class="text-xs text-gray-500">Position</label>
                  <select id="player-position-select" class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm">
                    <option value="GK">Goalkeeper</option>
                    <option value="LB">Left Back</option>
                    <option value="CB">Center Back</option>
                    <option value="RB">Right Back</option>
                    <option value="LWB">Left Wing Back</option>
                    <option value="RWB">Right Wing Back</option>
                    <option value="CDM">Defensive Midfielder</option>
                    <option value="CM">Center Midfielder</option>
                    <option value="CAM">Attacking Midfielder</option>
                    <option value="LM">Left Midfielder</option>
                    <option value="RM">Right Midfielder</option>
                    <option value="LW">Left Winger</option>
                    <option value="RW">Right Winger</option>
                    <option value="CF">Center Forward</option>
                    <option value="ST">Striker</option>
                  </select>
                </div>
                <div>
                  <label class="text-xs text-gray-500">Jersey Number</label>
                  <input type="number" id="player-number-input" min="1" max="99" class="w-full border border-gray-300 rounded-md px-2 py-1 text-sm">
                </div>
              </div>
              <button class="mt-2 btn btn-sm btn-primary w-full" id="update-player-position">
                Assign Position
              </button>
            </div>
          </div>
          
          <!-- Team Roster Section -->
          <div class="mt-4">
            <!-- Home team rosters -->
            <div id="home-rosters" class="mb-4" style="display: block;">
              <!-- Starting lineup -->
              <div class="mb-2">
                <h4 class="text-sm font-medium mb-2 text-blue-800">
                  <i class="fas fa-play-circle mr-1"></i> Starting Lineup
                </h4>
                <div class="space-y-1 max-h-[150px] overflow-y-auto" id="home-starting-players">
                  <!-- Starting players will be populated here -->
                </div>
              </div>
              
              <!-- Substitutes -->
              <div>
                <h4 class="text-sm font-medium mb-2 text-blue-800">
                  <i class="fas fa-exchange-alt mr-1"></i> Substitutes
                </h4>
                <div class="space-y-1 max-h-[150px] overflow-y-auto" id="home-substitute-players">
                  <!-- Substitute players will be populated here -->
                </div>
              </div>
            </div>
            
            <!-- Away team rosters -->
            <div id="away-rosters" class="mb-4" style="display: none;">
              <!-- Starting lineup -->
              <div class="mb-2">
                <h4 class="text-sm font-medium mb-2 text-red-800">
                  <i class="fas fa-play-circle mr-1"></i> Starting Lineup
                </h4>
                <div class="space-y-1 max-h-[150px] overflow-y-auto" id="away-starting-players">
                  <!-- Starting players will be populated here -->
                </div>
              </div>
              
              <!-- Substitutes -->
              <div>
                <h4 class="text-sm font-medium mb-2 text-red-800">
                  <i class="fas fa-exchange-alt mr-1"></i> Substitutes
                </h4>
                <div class="space-y-1 max-h-[150px] overflow-y-auto" id="away-substitute-players">
                  <!-- Substitute players will be populated here -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Away team players -->
      <div class="card">
        <div class="card-header bg-red-50">
          <h2 class="text-red-800 font-bold flex items-center">
            <i class="fas fa-user-circle mr-2"></i> Olympique Club de Khouribga
          </h2>
          <div class="text-sm text-gray-500 mt-1 flex space-x-2">
            <span>Starting: <span id="away-starting-count">0</span>/11 players</span>
            <span>Substitutes: <span id="away-substitute-count">0</span>/7 players</span>
          </div>
        </div>
        <div class="card-body">
          <div class="space-y-2 max-h-[42rem] overflow-y-auto pr-2" id="away-players-list">
            <!-- Away players will be populated here by JavaScript -->
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Referees tab -->
  <div id="referees-tab" class="tab-pane hidden">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Available referees -->
      <div class="card">
        <div class="card-header bg-purple-50">
          <h2 class="text-purple-800 font-bold flex items-center">
            <i class="fas fa-whistle mr-2"></i> Available Referees
          </h2>
        </div>
        <div class="card-body">
          <div class="space-y-2 max-h-[500px] overflow-y-auto pr-2" id="referees-list">
            <!-- Referees will be populated here by JavaScript -->
          </div>
        </div>
      </div>
      
      <!-- Assigned referees -->
      <div class="card">
        <div class="card-header bg-amber-50">
          <h2 class="text-amber-800 font-bold flex items-center">
            <i class="fas fa-flag mr-2"></i> Assigned Referees
          </h2>
        </div>
        <div class="card-body">
          <div class="space-y-4" id="assigned-referees">
            <!-- Main referee -->
            <div class="p-3 bg-gray-50 rounded-md">
              <div class="font-medium mb-2">Main Referee</div>
              <div id="main-referee" class="text-sm text-gray-500 italic">No referee assigned</div>
            </div>
            
            <!-- Assistant referees -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
              <div class="p-3 bg-gray-50 rounded-md">
                <div class="font-medium mb-2">Assistant Referee 1</div>
                <div id="assistant1-referee" class="text-sm text-gray-500 italic">No referee assigned</div>
              </div>
              <div class="p-3 bg-gray-50 rounded-md">
                <div class="font-medium mb-2">Assistant Referee 2</div>
                <div id="assistant2-referee" class="text-sm text-gray-500 italic">No referee assigned</div>
              </div>
            </div>
            
            <!-- Fourth official and VAR -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
              <div class="p-3 bg-gray-50 rounded-md">
                <div class="font-medium mb-2">Fourth Official</div>
                <div id="fourth-referee" class="text-sm text-gray-500 italic">No referee assigned</div>
              </div>
              <div class="p-3 bg-gray-50 rounded-md">
                <div class="font-medium mb-2">VAR</div>
                <div id="var-referee" class="text-sm text-gray-500 italic">No referee assigned</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Save button -->
<div class="mt-6 flex justify-end">
  <button class="btn btn-primary flex items-center">
    <i class="fas fa-save mr-2"></i> Save Match Setup
  </button>
</div>
</div>

<script>
// Data
// const homeTeamPlayers = generatePlayersWithSpecificPositions('Raja Club Athletic');
// const awayTeamPlayers = generatePlayersWithSpecificPositions('Olympique Club de Khouribga');
const homeTeamPlayers = <?php echo json_encode($homeTeamPlayers); ?>;
console.log(homeTeamPlayers);
const awayTeamPlayers = <?php echo json_encode($awayTeamPlayers); ?>;
const referees = generateReferees(6);

// State
let selectedHomeTeamPlayers = [];     // Starting players
let selectedAwayTeamPlayers = [];     // Starting players
let substituteHomeTeamPlayers = [];   // Substitute players
let substituteAwayTeamPlayers = [];   // Substitute players
let selectedReferees = {};
let homeTeamFormation = '4-3-3';
let awayTeamFormation = '4-3-3';
let playerPositions = []; // Array to store player positions on the field
let currentEditingPlayer = null; // Currently selected player for position editing
let currentlyViewingTeam = 'home'; // Currently viewing team lineup (home or away)

// Max players allowed
const MAX_STARTING_PLAYERS = 11;
const MAX_SUBSTITUTE_PLAYERS = 7;

// Position mappings for different formations
const positionMappings = {
  // Define position coordinates for each formation
  // Format: [x%, y%] where x is horizontal (0-100) and y is vertical (0-100)
  '4-3-3': {
    // Home team (bottom half)
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
    // Away team (top half)
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
    // Home team
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
    // Away team
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
    // Home team
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
    // Away team
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
    // Home team
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
    // Away team
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
    // Home team
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
    // Away team
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
    // Home team
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
    // Away team
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

// Position display names
const positionNames = {
  'GK': 'Goalkeeper',
  'LB': 'Left Back',
  'CB': 'Center Back',
  'CB2': 'Center Back',
  'CB3': 'Center Back',
  'RB': 'Right Back',
  'LWB': 'Left Wing Back',
  'RWB': 'Right Wing Back',
  'CDM': 'Defensive Mid',
  'CDM2': 'Defensive Mid',
  'CM': 'Center Mid',
  'CM2': 'Center Mid',
  'CAM': 'Attacking Mid',
  'LM': 'Left Mid',
  'RM': 'Right Mid',
  'LW': 'Left Wing',
  'RW': 'Right Wing',
  'CF': 'Center Forward',
  'ST': 'Striker',
  'ST2': 'Striker'
};

// DOM Elements
const tabs = document.querySelectorAll('.tab');
const tabPanes = document.querySelectorAll('.tab-pane');
const fieldTabs = document.querySelectorAll('.field-tab');
const teamLabel = document.getElementById('team-label');
const formationLabel = document.getElementById('formation-label');
const homeFormationSelect = document.getElementById('home-formation-select');
const awayFormationSelect = document.getElementById('away-formation-select');
const homePlayersList = document.getElementById('home-players-list');
const awayPlayersList = document.getElementById('away-players-list');
const homeStartingPlayers = document.getElementById('home-starting-players');
const awayStartingPlayers = document.getElementById('away-starting-players');
const homeSubstitutePlayers = document.getElementById('home-substitute-players');
const awaySubstitutePlayers = document.getElementById('away-substitute-players');
const homeStartingCount = document.getElementById('home-starting-count');
const awayStartingCount = document.getElementById('away-starting-count');
const homeSubstituteCount = document.getElementById('home-substitute-count');
const awaySubstituteCount = document.getElementById('away-substitute-count');
const homeRosters = document.getElementById('home-rosters');
const awayRosters = document.getElementById('away-rosters');
const playerPositionsContainer = document.getElementById('player-positions');
const refereesList = document.getElementById('referees-list');
const soccerField = document.getElementById('soccer-field');
const selectedPlayerInfo = document.getElementById('selected-player-info');
const editPlayerName = document.getElementById('edit-player-name');
const editPlayerTeam = document.getElementById('edit-player-team');
const playerPositionSelect = document.getElementById('player-position-select');
const playerNumberInput = document.getElementById('player-number-input');
const updatePlayerPositionBtn = document.getElementById('update-player-position');
const removeFromPositionBtn = document.getElementById('remove-from-position');

// Initialize
function init() {
  renderPlayers();
  renderReferees();
  renderPlayerPositions();
  setupEventListeners();
  updateFormationLabel();
}

// Event Listeners
function setupEventListeners() {
  // Tab switching
  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      const tabId = tab.getAttribute('data-tab');
      
      // Update active tab
      tabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
      
      // Show corresponding tab pane
      tabPanes.forEach(pane => pane.classList.add('hidden'));
      document.getElementById(`${tabId}-tab`).classList.remove('hidden');
    });
  });
  
  // Field Tab switching
  fieldTabs.forEach(tab => {
    tab.addEventListener('click', () => {
      const team = tab.getAttribute('data-team');
      
      // Update active field tab
      fieldTabs.forEach(t => {
        t.classList.remove('active');
        t.classList.remove('bg-blue-50', 'bg-red-50');
        t.classList.remove('text-blue-600', 'text-red-600');
        t.classList.add('bg-gray-50', 'text-gray-500');
      });
      
      tab.classList.add('active');
      
      if (team === 'home') {
        tab.classList.add('bg-blue-50', 'text-blue-600');
        teamLabel.textContent = 'Home Team Lineup';
        teamLabel.classList.remove('bg-red-600');
        teamLabel.classList.add('bg-blue-600');
        
        // Show home formation select, hide away formation select
        homeFormationSelect.style.display = 'block';
        awayFormationSelect.style.display = 'none';
        
        // Show home rosters, hide away rosters
        homeRosters.style.display = 'block';
        awayRosters.style.display = 'none';
      } else {
        tab.classList.add('bg-red-50', 'text-red-600');
        teamLabel.textContent = 'Away Team Lineup';
        teamLabel.classList.remove('bg-blue-600');
        teamLabel.classList.add('bg-red-600');
        
        // Show away formation select, hide home formation select
        homeFormationSelect.style.display = 'none';
        awayFormationSelect.style.display = 'block';
        
        // Show away rosters, hide home rosters
        homeRosters.style.display = 'none';
        awayRosters.style.display = 'block';
      }
      
      // Update current team view
      currentlyViewingTeam = team;
      
      // Update formation label
      updateFormationLabel();
      
      // Re-render player positions
      renderPlayerPositions();
    });
  });
  
  // Formation change for home team
  homeFormationSelect.addEventListener('change', () => {
    homeTeamFormation = homeFormationSelect.value;
    
    // Update player positions based on new formation
    updatePlayerPositionsForFormation('home');
    updateFormationLabel();
    renderPlayerPositions();
  });
  
  // Formation change for away team
  awayFormationSelect.addEventListener('change', () => {
    awayTeamFormation = awayFormationSelect.value;
    
    // Update player positions based on new formation
    updatePlayerPositionsForFormation('away');
    updateFormationLabel();
    renderPlayerPositions();
  });
  
  // Update player position button
  updatePlayerPositionBtn.addEventListener('click', () => {
    if (!currentEditingPlayer) return;
    
    const position = playerPositionSelect.value;
    const team = currentEditingPlayer.team;
    const currentFormation = team === 'home' ? homeTeamFormation : awayTeamFormation;
    
    // Find position coordinates based on formation
    const formationPositions = positionMappings[currentFormation][team];
    
    // Find a suitable position key (some positions like CB might have multiple spots)
    let positionKey = position;
    if (position === 'CB') {
      // Check if we already have CBs assigned and pick the next available one
      const existingCBs = playerPositions.filter(p => 
        p.team === team && (p.position === 'CB' || p.position === 'CB2' || p.position === 'CB3')
      );
      
      if (existingCBs.length === 0) positionKey = 'CB';
      else if (existingCBs.length === 1) positionKey = 'CB2';
      else if (existingCBs.length === 2 && currentFormation.startsWith('3') || currentFormation.startsWith('5')) positionKey = 'CB3';
    } else if (position === 'ST' && (currentFormation === '4-4-2' || currentFormation === '3-5-2')) {
      // Check if we already have a striker assigned
      const existingST = playerPositions.find(p => p.team === team && p.position === 'ST');
      if (existingST) positionKey = 'ST2';
    } else if (position === 'CDM' && currentFormation === '4-2-3-1') {
      // Check if we already have a CDM assigned
      const existingCDM = playerPositions.find(p => p.team === team && p.position === 'CDM');
      if (existingCDM) positionKey = 'CDM2';
    } else if (position === 'CM' && (currentFormation === '4-4-2' || currentFormation === '3-4-3')) {
      // Check if we already have a CM assigned
      const existingCM = playerPositions.find(p => p.team === team && p.position === 'CM');
      if (existingCM) positionKey = 'CM2';
    }
    
    // Get coordinates for the position
    const coordinates = formationPositions[positionKey] || [50, team === 'home' ? 60 : 40];
    
    // Update or add player position
    const playerIndex = playerPositions.findIndex(p => 
      p.id === currentEditingPlayer.id && p.team === currentEditingPlayer.team
    );
    
    const updatedPosition = {
      id: currentEditingPlayer.id,
      team: currentEditingPlayer.team,
      name: currentEditingPlayer.name,
      position: position,
      positionKey: positionKey,
      number: parseInt(playerNumberInput.value) || 0,
      x: coordinates[0],
      y: coordinates[1]
    };
    
    if (playerIndex !== -1) {
      // Update existing position
      playerPositions[playerIndex] = updatedPosition;
    } else {
      // Add new position
      playerPositions.push(updatedPosition);
    }
    
    // Clear selection
    currentEditingPlayer = null;
    selectedPlayerInfo.classList.add('hidden');
    
    renderPlayerPositions();
  });
  
  // Remove player from position
  removeFromPositionBtn.addEventListener('click', () => {
    if (!currentEditingPlayer) return;
    
    playerPositions = playerPositions.filter(p => 
      !(p.id === currentEditingPlayer.id && p.team === currentEditingPlayer.team)
    );
    
    currentEditingPlayer = null;
    selectedPlayerInfo.classList.add('hidden');
    renderPlayerPositions();
  });
}

// Update formation label
function updateFormationLabel() {
  const currentFormation = currentlyViewingTeam === 'home' ? homeTeamFormation : awayTeamFormation;
  formationLabel.textContent = currentFormation;
}

// Render players lists
function renderPlayers() {
  // Render home team players
  homePlayersList.innerHTML = homeTeamPlayers.map(player => {
    const isStartingPlayer = selectedHomeTeamPlayers.some(p => p.id === player.id);
    const isSubstitutePlayer = substituteHomeTeamPlayers.some(p => p.id === player.id);
    const isAdded = isStartingPlayer || isSubstitutePlayer;
    const hasMaxStarting = selectedHomeTeamPlayers.length >= MAX_STARTING_PLAYERS;
    const hasMaxSubstitutes = substituteHomeTeamPlayers.length >= MAX_SUBSTITUTE_PLAYERS;
    
    return `
      <div class="flex items-center justify-between p-2 bg-gray-50 rounded-md" data-player-id="${player.id}">
        <div>
          <div class="font-medium"> ${player.surname} ${player.name}</div>
          <div class="text-sm text-gray-500">${player.position}</div>
        </div>
        <div class="flex gap-1">
          ${!isAdded ? `
            <div class="flex gap-1">
              ${!hasMaxStarting ? `
                <button class="btn btn-sm btn-outline add-player" data-team="home" data-role="starting" data-player-id="${player.id}">
                  <i class="fas fa-play-circle"></i>
                </button>
              ` : ''}
              ${!hasMaxSubstitutes ? `
                <button class="btn btn-sm btn-outline add-player" data-team="home" data-role="substitute" data-player-id="${player.id}">
                  <i class="fas fa-exchange-alt"></i>
                </button>
              ` : ''}
            </div>
          ` : `
            <div class="flex items-center gap-1">
              <span class="text-xs text-gray-500">${isStartingPlayer ? 'Starting' : 'Substitute'}</span>
              ${isStartingPlayer && playerPositions.some(p => p.id === player.id && p.team === 'home') ? `
                <button class="btn btn-sm btn-outline position-player" data-team="home" data-player-id="${player.id}">
                  <i class="fas fa-map-marker-alt"></i>
                </button>
              ` : ''}
            </div>
          `}
        </div>
      </div>
    `;
  }).join('');
  
  // Render away team players
  awayPlayersList.innerHTML = awayTeamPlayers.map(player => {
    const isStartingPlayer = selectedAwayTeamPlayers.some(p => p.id === player.id);
    const isSubstitutePlayer = substituteAwayTeamPlayers.some(p => p.id === player.id);
    const isAdded = isStartingPlayer || isSubstitutePlayer;
    const hasMaxStarting = selectedAwayTeamPlayers.length >= MAX_STARTING_PLAYERS;
    const hasMaxSubstitutes = substituteAwayTeamPlayers.length >= MAX_SUBSTITUTE_PLAYERS;
    
    return `
      <div class="flex items-center justify-between p-2 bg-gray-50 rounded-md" data-player-id="${player.id}">
        <div>
          <div class="font-medium">${player.name}</div>
          <div class="text-sm text-gray-500">${player.position}</div>
        </div>
        <div class="flex gap-1">
          ${!isAdded ? `
            <div class="flex gap-1">
              ${!hasMaxStarting ? `
                <button class="btn btn-sm btn-outline add-player" data-team="away" data-role="starting" data-player-id="${player.id}">
                  <i class="fas fa-play-circle"></i>
                </button>
              ` : ''}
              ${!hasMaxSubstitutes ? `
                <button class="btn btn-sm btn-outline add-player" data-team="away" data-role="substitute" data-player-id="${player.id}">
                  <i class="fas fa-exchange-alt"></i>
                </button>
              ` : ''}
            </div>
          ` : `
            <div class="flex items-center gap-1">
              <span class="text-xs text-gray-500">${isStartingPlayer ? 'Starting' : 'Substitute'}</span>
              ${isStartingPlayer && playerPositions.some(p => p.id === player.id && p.team === 'away') ? `
                <button class="btn btn-sm btn-outline position-player" data-team="away" data-player-id="${player.id}">
                  <i class="fas fa-map-marker-alt"></i>
                </button>
              ` : ''}
            </div>
          `}
        </div>
      </div>
    `;
  }).join('');
  
  // Add event listeners to add player buttons
  document.querySelectorAll('.add-player').forEach(button => {
    button.addEventListener('click', () => {
      const playerId = parseInt(button.getAttribute('data-player-id'));
      const team = button.getAttribute('data-team');
      const role = button.getAttribute('data-role');
      
      if (team === 'home') {
        const player = homeTeamPlayers.find(p => p.id === playerId);
        addPlayerToTeam(player, team, role);
      } else {
        const player = awayTeamPlayers.find(p => p.id === playerId);
        addPlayerToTeam(player, team, role);
      }
    });
  });
  
  // Add event listeners to position player buttons
  document.querySelectorAll('.position-player').forEach(button => {
    button.addEventListener('click', () => {
      const playerId = parseInt(button.getAttribute('data-player-id'));
      const team = button.getAttribute('data-team');
      
      let player;
      if (team === 'home') {
        player = selectedHomeTeamPlayers.find(p => p.id === playerId);
      } else {
        player = selectedAwayTeamPlayers.find(p => p.id === playerId);
      }
      
      if (player) {
        selectPlayerForPositioning(player, team);
      }
    });
  });
  
  // Update selected players
  updateTeamLists();
}

// Select player for positioning
function selectPlayerForPositioning(player, team) {
  currentEditingPlayer = { ...player, team };
  
  // Find if player already has a position
  const existingPosition = playerPositions.find(p => 
    p.id === player.id && p.team === team
  );
  
  // Update UI
  editPlayerName.textContent = player.name;
  editPlayerTeam.textContent = team === 'home' ? 'Raja Club Athletic' : 'Olympique Club de Khouribga';
  
  if (existingPosition) {
    playerPositionSelect.value = existingPosition.position;
    playerNumberInput.value = existingPosition.number;
  } else {
    // Default values - use the player's specific position
    playerPositionSelect.value = player.tag || 'CM';
    playerNumberInput.value = player.number || player.id;
  }
  
  selectedPlayerInfo.classList.remove('hidden');
  
  // Switch to the tab of the selected player's team
  switchFieldTab(team);
}

// Switch to a specific field tab
function switchFieldTab(team) {
  if (currentlyViewingTeam !== team) {
    // Find and click the appropriate tab
    const tab = document.querySelector(`.field-tab[data-team="${team}"]`);
    if (tab) {
      tab.click();
    }
  }
}

// Update player positions for formation change
function updatePlayerPositionsForFormation(team) {
  const currentFormation = team === 'home' ? homeTeamFormation : awayTeamFormation;
  
  // Update existing player positions based on new formation
  playerPositions.forEach(player => {
    if (player.team === team) {
      const formationPositions = positionMappings[currentFormation][team];
      
      // Find the closest matching position in the new formation
      let positionKey = player.position;
      
      // Handle special cases for positions that might have multiple spots
      if (player.position === 'CB' || player.position === 'CB2' || player.position === 'CB3') {
        // Find all CBs for this team
        const teamCBs = playerPositions.filter(p => 
          p.team === team && (p.position === 'CB' || p.position === 'CB2' || p.position === 'CB3')
        );
        
        // Sort by player ID to maintain consistent ordering
        teamCBs.sort((a, b) => a.id - b.id);
        
        // Assign position keys based on order
        const cbIndex = teamCBs.findIndex(cb => cb.id === player.id);
        if (cbIndex === 0) positionKey = 'CB';
        else if (cbIndex === 1) positionKey = 'CB2';
        else if (cbIndex === 2) positionKey = 'CB3';
      }
      
      // Get coordinates for the position in the new formation
      const coordinates = formationPositions[positionKey] || formationPositions[player.position] || [50, team === 'home' ? 60 : 40];
      
      // Update coordinates
      player.x = coordinates[0];
      player.y = coordinates[1];
    }
  });
}

// Render referees list
function renderReferees() {
  refereesList.innerHTML = referees.map(referee => `
    <div class="p-3 bg-gray-50 rounded-md">
      <div class="font-medium">${referee.name}</div>
      <div class="text-sm text-gray-500 mb-2">Experience: ${referee.experience} years</div>
      <div class="flex flex-wrap gap-2 mt-2">
        <button class="btn btn-sm btn-outline text-xs assign-referee" 
          data-referee-id="${referee.id}" data-role="main">
          Main Referee
        </button>
        <button class="btn btn-sm btn-outline text-xs assign-referee" 
          data-referee-id="${referee.id}" data-role="assistant1">
          Assistant 1
        </button>
        <button class="btn btn-sm btn-outline text-xs assign-referee" 
          data-referee-id="${referee.id}" data-role="assistant2">
          Assistant 2
        </button>
        <button class="btn btn-sm btn-outline text-xs assign-referee" 
          data-referee-id="${referee.id}" data-role="fourth">
          Fourth Official
        </button>
        <button class="btn btn-sm btn-outline text-xs assign-referee" 
          data-referee-id="${referee.id}" data-role="var">
          VAR
        </button>
      </div>
    </div>
  `).join('');
  
  // Add event listeners to assign referee buttons
  document.querySelectorAll('.assign-referee').forEach(button => {
    button.addEventListener('click', () => {
      const refereeId = parseInt(button.getAttribute('data-referee-id'));
      const role = button.getAttribute('data-role');
      const referee = referees.find(r => r.id === refereeId);
      
      assignReferee(referee, role);
    });
  });
}

// Add player to team (starting or substitute)
function addPlayerToTeam(player, team, role) {
  if (team === 'home') {
    if (role === 'starting') {
      if (selectedHomeTeamPlayers.length >= MAX_STARTING_PLAYERS) return;
      selectedHomeTeamPlayers.push(player);
      
      // Auto-assign a position if it's a starting player
      autoAssignPosition(player, team);
    } else {
      if (substituteHomeTeamPlayers.length >= MAX_SUBSTITUTE_PLAYERS) return;
      substituteHomeTeamPlayers.push(player);
    }
  } else {
    if (role === 'starting') {
      if (selectedAwayTeamPlayers.length >= MAX_STARTING_PLAYERS) return;
      selectedAwayTeamPlayers.push(player);
      
      // Auto-assign a position if it's a starting player
      autoAssignPosition(player, team);
    } else {
      if (substituteAwayTeamPlayers.length >= MAX_SUBSTITUTE_PLAYERS) return;
      substituteAwayTeamPlayers.push(player);
    }
  }
  
  updateTeamLists();
  renderPlayers(); // Re-render to update disabled states
  
  // Switch to this team's tab to show the newly added player
  switchFieldTab(team);
}

// Move player between starting lineup and substitutes
function movePlayer(playerId, team, targetRole) {
  if (team === 'home') {
    if (targetRole === 'starting') {
      // Check if we can add to starting lineup
      if (selectedHomeTeamPlayers.length >= MAX_STARTING_PLAYERS) return;
      
      // Find player in substitutes
      const playerIndex = substituteHomeTeamPlayers.findIndex(p => p.id === playerId);
      if (playerIndex === -1) return;
      
      // Move from substitutes to starting
      const player = substituteHomeTeamPlayers[playerIndex];
      substituteHomeTeamPlayers.splice(playerIndex, 1);
      selectedHomeTeamPlayers.push(player);
      
      // Auto-assign position
      autoAssignPosition(player, team);
    } else {
      // Check if we can add to substitutes
      if (substituteHomeTeamPlayers.length >= MAX_SUBSTITUTE_PLAYERS) return;
      
      // Find player in starting lineup
      const playerIndex = selectedHomeTeamPlayers.findIndex(p => p.id === playerId);
      if (playerIndex === -1) return;
      
      // Move from starting to substitutes
      const player = selectedHomeTeamPlayers[playerIndex];
      selectedHomeTeamPlayers.splice(playerIndex, 1);
      substituteHomeTeamPlayers.push(player);
      
      // Remove from positions
      playerPositions = playerPositions.filter(p => !(p.id === playerId && p.team === team));
    }
  } else {
    if (targetRole === 'starting') {
      // Check if we can add to starting lineup
      if (selectedAwayTeamPlayers.length >= MAX_STARTING_PLAYERS) return;
      
      // Find player in substitutes
      const playerIndex = substituteAwayTeamPlayers.findIndex(p => p.id === playerId);
      if (playerIndex === -1) return;
      
      // Move from substitutes to starting
      const player = substituteAwayTeamPlayers[playerIndex];
      substituteAwayTeamPlayers.splice(playerIndex, 1);
      selectedAwayTeamPlayers.push(player);
      
      // Auto-assign position
      autoAssignPosition(player, team);
    } else {
      // Check if we can add to substitutes
      if (substituteAwayTeamPlayers.length >= MAX_SUBSTITUTE_PLAYERS) return;
      
      // Find player in starting lineup
      const playerIndex = selectedAwayTeamPlayers.findIndex(p => p.id === playerId);
      if (playerIndex === -1) return;
      
      // Move from starting to substitutes
      const player = selectedAwayTeamPlayers[playerIndex];
      selectedAwayTeamPlayers.splice(playerIndex, 1);
      substituteAwayTeamPlayers.push(player);
      
      // Remove from positions
      playerPositions = playerPositions.filter(p => !(p.id === playerId && p.team === team));
    }
  }
  
  updateTeamLists();
  renderPlayers();
  renderPlayerPositions();
}

// Auto-assign position based on player role
function autoAssignPosition(player, team) {
  // Skip if player already has a position
  const existingPosition = playerPositions.find(p => 
    p.id === player.id && p.team === team
  );
  
  if (existingPosition) return;
  
  const currentFormation = team === 'home' ? homeTeamFormation : awayTeamFormation;
  
  // Use the player's specific position directly
  let position = player.tag;
  
  // If we determined a position, assign it
  if (position) {
    const formationPositions = positionMappings[currentFormation][team];
    
    // Find position key (for positions with multiple spots like CB)
    let positionKey = position;
    
    // Handle special cases for positions that might have multiple spots
    if (position === 'CB') {
      // Check if we already have CBs assigned and pick the next available one
      const existingCBs = playerPositions.filter(p => 
        p.team === team && (p.position === 'CB' || p.position === 'CB2' || p.position === 'CB3')
      );
      
      if (existingCBs.length === 0) positionKey = 'CB';
      else if (existingCBs.length === 1) positionKey = 'CB2';
      else if (existingCBs.length === 2 && (currentFormation.startsWith('3') || currentFormation.startsWith('5'))) positionKey = 'CB3';
      else positionKey = 'CB'; // Default if all spots are taken
    }
    
    // Get coordinates for the position
    const coordinates = formationPositions[positionKey] || [50, team === 'home' ? 60 : 40];
    
    // Add player position
    playerPositions.push({
      id: player.id,
      team: team,
      name: player.name,
      position: position,
      positionKey: positionKey,
      number: player.number || player.id,
      x: coordinates[0],
      y: coordinates[1]
    });
    
    renderPlayerPositions();
  }
}

// Remove player from team completely
function removePlayerFromTeam(playerId, team) {
  if (team === 'home') {
    // Check if player is in starting lineup
    const startingIndex = selectedHomeTeamPlayers.findIndex(p => p.id === playerId);
    if (startingIndex !== -1) {
      selectedHomeTeamPlayers.splice(startingIndex, 1);
    } else {
      // Check if player is in substitutes
      const substituteIndex = substituteHomeTeamPlayers.findIndex(p => p.id === playerId);
      if (substituteIndex !== -1) {
        substituteHomeTeamPlayers.splice(substituteIndex, 1);
      }
    }
  } else {
    // Check if player is in starting lineup
    const startingIndex = selectedAwayTeamPlayers.findIndex(p => p.id === playerId);
    if (startingIndex !== -1) {
      selectedAwayTeamPlayers.splice(startingIndex, 1);
    } else {
      // Check if player is in substitutes
      const substituteIndex = substituteAwayTeamPlayers.findIndex(p => p.id === playerId);
      if (substituteIndex !== -1) {
        substituteAwayTeamPlayers.splice(substituteIndex, 1);
      }
    }
  }
  
  // Also remove from positions
  playerPositions = playerPositions.filter(p => !(p.id === playerId && p.team === team));
  
  updateTeamLists();
  renderPlayers(); // Re-render to update disabled states
  renderPlayerPositions();
  
  // If the removed player was being edited, clear the editor
  if (currentEditingPlayer && currentEditingPlayer.id === playerId && currentEditingPlayer.team === team) {
    currentEditingPlayer = null;
    selectedPlayerInfo.classList.add('hidden');
  }
}

// Update team lists display
function updateTeamLists() {
  // Update counts
  homeStartingCount.textContent = selectedHomeTeamPlayers.length;
  awayStartingCount.textContent = selectedAwayTeamPlayers.length;
  homeSubstituteCount.textContent = substituteHomeTeamPlayers.length;
  awaySubstituteCount.textContent = substituteAwayTeamPlayers.length;
  
  // Update home starting players
  homeStartingPlayers.innerHTML = selectedHomeTeamPlayers.map(player => {
    const playerPosition = playerPositions.find(p => p.id === player.id && p.team === 'home');
    const positionText = playerPosition ? ` (${playerPosition.position})` : '';
    
    return `
      <div class="flex items-center justify-between text-xs p-1 bg-blue-50 rounded">
        <div class="flex items-center">
          <span class="inline-block w-5 h-5 bg-blue-500 text-white rounded-full text-center mr-1.5">
            ${player.number || '?'}
          </span>
          <span>${player.name}${positionText}</span>
        </div>
        <div class="flex gap-1">
          <button class="text-gray-500 hover:text-blue-500 position-player-small" data-team="home" data-player-id="${player.id}">
            <i class="fas fa-map-marker-alt"></i>
          </button>
          <button class="text-gray-500 hover:text-amber-500 move-player" data-team="home" data-role="substitute" data-player-id="${player.id}">
            <i class="fas fa-exchange-alt"></i>
          </button>
          <button class="text-gray-500 hover:text-red-500 remove-player" data-team="home" data-player-id="${player.id}">
            <i class="fas fa-minus-circle"></i>
          </button>
        </div>
      </div>
    `;
  }).join('');
  
  // Update home substitute players
  homeSubstitutePlayers.innerHTML = substituteHomeTeamPlayers.map(player => {
    return `
      <div class="flex items-center justify-between text-xs p-1 bg-blue-50/50 rounded">
        <div class="flex items-center">
          <span class="inline-block w-5 h-5 bg-blue-300 text-white rounded-full text-center mr-1.5">
            ${player.number || '?'}
          </span>
          <span>${player.name}</span>
        </div>
        <div class="flex gap-1">
          <button class="text-gray-500 hover:text-amber-500 move-player" data-team="home" data-role="starting" data-player-id="${player.id}">
            <i class="fas fa-play-circle"></i>
          </button>
          <button class="text-gray-500 hover:text-red-500 remove-player" data-team="home" data-player-id="${player.id}">
            <i class="fas fa-minus-circle"></i>
          </button>
        </div>
      </div>
    `;
  }).join('');
  
  // Update away starting players
  awayStartingPlayers.innerHTML = selectedAwayTeamPlayers.map(player => {
    const playerPosition = playerPositions.find(p => p.id === player.id && p.team === 'away');
    const positionText = playerPosition ? ` (${playerPosition.position})` : '';
    
    return `
      <div class="flex items-center justify-between text-xs p-1 bg-red-50 rounded">
        <div class="flex items-center">
          <span class="inline-block w-5 h-5 bg-red-500 text-white rounded-full text-center mr-1.5">
            ${player.number || '?'}
          </span>
          <span>${player.name}${positionText}</span>
        </div>
        <div class="flex gap-1">
          <button class="text-gray-500 hover:text-red-500 position-player-small" data-team="away" data-player-id="${player.id}">
            <i class="fas fa-map-marker-alt"></i>
          </button>
          <button class="text-gray-500 hover:text-amber-500 move-player" data-team="away" data-role="substitute" data-player-id="${player.id}">
            <i class="fas fa-exchange-alt"></i>
          </button>
          <button class="text-gray-500 hover:text-red-500 remove-player" data-team="away" data-player-id="${player.id}">
            <i class="fas fa-minus-circle"></i>
          </button>
        </div>
      </div>
    `;
  }).join('');
  
  // Update away substitute players
  awaySubstitutePlayers.innerHTML = substituteAwayTeamPlayers.map(player => {
    return `
      <div class="flex items-center justify-between text-xs p-1 bg-red-50/50 rounded">
        <div class="flex items-center">
          <span class="inline-block w-5 h-5 bg-red-300 text-white rounded-full text-center mr-1.5">
            ${player.number || '?'}
          </span>
          <span>${player.name}</span>
        </div>
        <div class="flex gap-1">
          <button class="text-gray-500 hover:text-amber-500 move-player" data-team="away" data-role="starting" data-player-id="${player.id}">
            <i class="fas fa-play-circle"></i>
          </button>
          <button class="text-gray-500 hover:text-red-500 remove-player" data-team="away" data-player-id="${player.id}">
            <i class="fas fa-minus-circle"></i>
          </button>
        </div>
      </div>
    `;
  }).join('');
  
  // Add event listeners to remove player buttons
  document.querySelectorAll('.remove-player').forEach(button => {
    button.addEventListener('click', () => {
      const playerId = parseInt(button.getAttribute('data-player-id'));
      const team = button.getAttribute('data-team');
      removePlayerFromTeam(playerId, team);
    });
  });
  
  // Add event listeners to move player buttons
  document.querySelectorAll('.move-player').forEach(button => {
    button.addEventListener('click', () => {
      const playerId = parseInt(button.getAttribute('data-player-id'));
      const team = button.getAttribute('data-team');
      const targetRole = button.getAttribute('data-role');
      movePlayer(playerId, team, targetRole);
    });
  });
  
  // Add event listeners to position player buttons
  document.querySelectorAll('.position-player-small').forEach(button => {
    button.addEventListener('click', () => {
      const playerId = parseInt(button.getAttribute('data-player-id'));
      const team = button.getAttribute('data-team');
      
      let player;
      if (team === 'home') {
        player = selectedHomeTeamPlayers.find(p => p.id === playerId);
      } else {
        player = selectedAwayTeamPlayers.find(p => p.id === playerId);
      }
      
      if (player) {
        selectPlayerForPositioning(player, team);
      }
    });
  });
}

// Assign referee to role
function assignReferee(referee, role) {
  selectedReferees[role] = referee;
  updateAssignedReferees();
}

// Update assigned referees display
function updateAssignedReferees() {
  const roles = ['main', 'assistant1', 'assistant2', 'fourth', 'var'];
  
  roles.forEach(role => {
    const element = document.getElementById(`${role}-referee`);
    const referee = selectedReferees[role];
    
    if (referee) {
      element.innerHTML = `
        <div class="flex items-center justify-between">
          <div>
            <div class="font-medium">${referee.name}</div>
            <div class="text-sm text-gray-500">Experience: ${referee.experience} years</div>
          </div>
          <span class="badge badge-green">Assigned</span>
        </div>
      `;
    } else {
      element.innerHTML = `<div class="text-sm text-gray-500 italic">No referee assigned</div>`;
    }
  });
}

// Render player positions on the field
function renderPlayerPositions() {
  playerPositionsContainer.innerHTML = '';
  
  // Only show starting players for the currently selected team
  const filteredPositions = playerPositions.filter(player => player.team === currentlyViewingTeam);
  
  filteredPositions.forEach(player => {
    const teamClass = player.team === 'home' ? 'player-dot-home' : 'player-dot-away';
    const positionDisplay = positionNames[player.position] || player.position;
    
    playerPositionsContainer.innerHTML += `
      <div class="player-dot ${teamClass}" 
        style="left: ${player.x}%; top: ${player.y}%; transform: translate(-50%, -50%);"
        data-player-id="${player.id}" data-team="${player.team}">
        <div class="text-[10px] font-bold">${player.number}</div>
        <div class="absolute -bottom-6 text-[10px] font-medium bg-black/70 text-white px-1 rounded whitespace-nowrap">
          ${positionDisplay}
        </div>
      </div>
    `;
  });
  
  // Add event listeners to player dots for selection
  document.querySelectorAll('.player-dot').forEach(dot => {
    dot.addEventListener('click', () => {
      const playerId = parseInt(dot.getAttribute('data-player-id'));
      const team = dot.getAttribute('data-team');
      
      // Find the player
      let player;
      if (team === 'home') {
        player = selectedHomeTeamPlayers.find(p => p.id === playerId);
      } else {
        player = selectedAwayTeamPlayers.find(p => p.id === playerId);
      }
      
      if (player) {
        // Remove selected class from all dots
        document.querySelectorAll('.player-dot').forEach(d => d.classList.remove('selected'));
        
        // Add selected class to this dot
        dot.classList.add('selected');
        
        // Select for editing
        selectPlayerForPositioning(player, team);
      }
    });
  });
}

// Helper function to generate players with specific positions
function generatePlayersWithSpecificPositions(teamName) {
  const players = [];
  let id = 1;
  
  // Define specific positions and how many of each to create
  const positionDistribution = [
    { position: 'Goalkeeper', tag: 'GK', count: 3 },
    { position: 'Left Back', tag: 'LB', count: 2 },
    { position: 'Center Back', tag: 'CB', count: 4 },
    { position: 'Right Back', tag: 'RB', count: 2 },
    { position: 'Defensive Midfielder', tag: 'CDM', count: 2 },
    { position: 'Center Midfielder', tag: 'CM', count: 3 },
    { position: 'Attacking Midfielder', tag: 'CAM', count: 2 },
    { position: 'Left Midfielder', tag: 'LM', count: 1 },
    { position: 'Right Midfielder', tag: 'RM', count: 1 },
    { position: 'Left Wing', tag: 'LW', count: 2 },
    { position: 'Right Wing', tag: 'RW', count: 2 },
    { position: 'Striker', tag: 'ST', count: 3 },
    { position: 'Center Forward', tag: 'CF', count: 1 }
  ];
  
  // Create players for each position
  positionDistribution.forEach(posInfo => {
    for (let i = 0; i < posInfo.count; i++) {
      players.push({
        id: id,
        name: `${posInfo.tag} Player ${id}`,
        position: posInfo.position,
        tag: posInfo.tag,
        team: teamName,
        number: id
      });
      id++;
    }
  });
  
  return players;
}

// Helper function to generate mock referees
function generateReferees(count) {
  const referees = [];
  
  for (let i = 1; i <= count; i++) {
    referees.push({
      id: i,
      name: `Referee ${i}`,
      experience: Math.floor(Math.random() * 15) + 3, // 3-18 years of experience
      nationality: 'Morocco'
    });
  }
  
  return referees;
}

// Initialize the app
document.addEventListener('DOMContentLoaded', init);
</script>
</body>
</html>

