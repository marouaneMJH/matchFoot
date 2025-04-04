<?php
require_once __DIR__ . '/../../../controller/GameMatchController.php';
require_once __DIR__ . '/../../../controller/LineupController.php';
require_once __DIR__ . '/../../../controller/GoalTypeController.php';
require_once __DIR__ . '/../../../controller/GoalController.php';
require_once __DIR__ . '/../../../controller/CardController.php';
require_once __DIR__ . '/../../../controller/SubstitutionController.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['match_id'], $_POST['events'])) {
  $matchId = $_POST['match_id'];
  $event = json_decode($_POST['events'], true);
  // var_dump($event);
  $isEditing_id = $event[0][0]['isEditing_id'] ?? null;
  if ($isEditing_id) {
    $_POST['event_id'] = $isEditing_id;
  }
  switch ($event[0][0]['type']) {
    case 'G':
      $_POST['lineup_id'] = $event[0][0]['lineup_player'];
      $_POST['minute'] = $event[0][0]['minute'];
      $_POST['goal_type'] = $event[0][0]['goal_type'];
      $_POST['assistor_id'] = $event[0][0]['assist_player'];
      // var_dump($_POST);
      $result = $isEditing_id ? GoalController::update() : GoalController::store();
      break;
    case 'C':
      $_POST['lineup_id'] = $event[0][0]['lineup_player'];
      $_POST['minute'] = $event[0][0]['minute'];
      $_POST['card_type'] = $event[0][0]['card_type'];

      $result = $isEditing_id ? CardController::update() : CardController::store();
      break;
    case 'S':
      // var_dump($event[0][0]);
      // die();
      $_POST['lineup_1_id'] = $event[0][0]['lineup_player_in'];
      $_POST['lineup_2_id'] = $event[0][0]['lineup_player_out'];
      $_POST['minute'] = $event[0][0]['minute'];
      $result = $isEditing_id ? SubstitutionController::update() : SubstitutionController::store();
      break;
  }
} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_DELETE['event_id'], $_DELETE['event_type'])) {
  var_dump($_DELETE);
  die();
}

if (!isset($_GET['match_id'])) {
  header("Location: ./TournamentInfos.php");
  exit;
}

$matchId = $_GET['match_id'];
$match = GameMatchController::getGameMatchById($matchId);
$lineups = LineupController::getAllLineupDataByMatchId($matchId);
$goalTypes = GoalTypeController::index();
$goals = GoalController::getGoalsByMatchId($matchId);
$cards = CardController::getCardsByMatchId($matchId);
$substitutions = SubstitutionController::getSubstitutionsByMatchId($matchId);


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Live Match Events Tracker</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            primary: {
              DEFAULT: 'rgb(var(--color-primary) / <alpha-value>)',
              foreground: 'rgb(var(--color-primary-foreground) / <alpha-value>)',
            },
            muted: {
              DEFAULT: 'rgb(var(--color-muted) / <alpha-value>)',
              foreground: 'rgb(var(--color-muted-foreground) / <alpha-value>)',
            },
            destructive: {
              DEFAULT: 'rgb(var(--color-destructive) / <alpha-value>)',
              foreground: 'rgb(var(--color-destructive-foreground) / <alpha-value>)',
            },
          }
        }
      }
    }
  </script>
  <style type="text/css">
    :root {
      --color-primary: 34 197 94;
      /* Green-500 */
      --color-primary-foreground: 255 255 255;
      --color-muted: 240 253 244;
      /* Green-50 */
      --color-muted-foreground: 20 83 45;
      /* Green-900 */
      --color-destructive: 239 68 68;
      --color-destructive-foreground: 255 255 255;
    }

    .scrollbar-hide::-webkit-scrollbar {
      display: none;
    }

    .scrollbar-hide {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }
  </style>
</head>

<body class="bg-green-50">


  <div class="container mx-auto p-4">
    <a href="./TournamentInfos.php" class="flex items-center text-gray-600 mb-4 hover:text-gray-800">
      <i class="fas fa-arrow-left mr-2"></i> Back to Matches
    </a>
    <div class="bg-white rounded-lg shadow-md mb-6">
      <div class="p-4 pb-2 border-b">
        <div class="flex justify-between items-center">
          <div class="flex items-center gap-2">
            <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold text-red-500">LIVE</span>
            <h2 class="text-lg font-bold">Match Events</h2>
          </div>
          <div class="flex items-center gap-2">
            <i class="ri-time-line text-sm text-muted-foreground"></i>
            <span class="text-sm font-medium" id="match-time"><?php echo $match['minute'] ?>m</span>
          </div>
        </div>
        <p class="text-sm text-muted-foreground">
          Record live match events as they happen
        </p>
      </div>

      <div class="p-4">
        <div class="flex justify-between items-center mb-6 bg-muted p-4 rounded-lg">
          <div class="flex items-center gap-3">
            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
              <img src="https://via.placeholder.com/40" alt="Home Team" id="home-team-logo" class="h-full w-full object-cover">
            </div>
            <div class="font-semibold" id="home-team-name"></div>
          </div>

          <div class="flex items-center gap-4">
            <div class="text-3xl font-bold" id="home-score">0</div>
            <div class="text-xl font-bold text-muted-foreground">-</div>
            <div class="text-3xl font-bold" id="away-score">0</div>
          </div>

          <div class="flex items-center gap-3">
            <div class="font-semibold" id="away-team-name">Real Madrid</div>
            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
              <img src="https://via.placeholder.com/40" alt="Away Team" id="away-team-logo" class="h-full w-full object-cover">
            </div>
          </div>
        </div>

        <div class="w-full">
          <div class="border-b">
            <div class="grid w-full grid-cols-3 mb-4">
              <button type="button" class="event-tab py-2 px-4 text-sm font-medium rounded-tl-md" data-tab="goal">
                <i class="ri-trophy-line mr-1"></i> Goal
              </button>
              <button type="button" class="event-tab py-2 px-4 text-sm font-medium" data-tab="card">
                <i class="ri-alert-line mr-1"></i> Card
              </button>
              <button type="button" class="event-tab py-2 px-4 text-sm font-medium rounded-tr-md" data-tab="substitution">
                <i class="ri-arrow-left-right-line mr-1"></i> Substitution
              </button>
            </div>
          </div>

          <div class="space-y-4 mb-6">
            <div class="grid grid-cols-2 gap-4 mt-4">
              <div>
                <label class="text-sm font-medium mb-1 block">Team</label>
                <select id="team-select" class="w-full rounded-md border border-gray-300 p-2 text-sm">
                  <option value="homeTeam">FC Barcelona</option>
                  <option value="awayTeam">Real Madrid</option>
                </select>
              </div>

              <div>
                <label class="text-sm font-medium mb-1 block" id="player-label">Player</label>
                <select id="player-select" class="w-full rounded-md border border-gray-300 p-2 text-sm">
                  <option value="">Select player</option>
                </select>
              </div>
            </div>

            <div id="goal-content" class="event-content">
              <div>
                <label class="text-sm font-medium mb-1 block">Goal Type</label>
                <select id="goal-type-select" class="w-full rounded-md border border-gray-300 p-2 text-sm">
                  <option value="">Select goal type</option>
                  <option value="1">Normal Goal</option>
                  <option value="2">Penalty</option>
                  <option value="3">Free Kick</option>
                  <option value="4">Header</option>
                  <option value="5">Own Goal</option>
                </select>
              </div>
              <div class="mt-4">
                <label class="text-sm font-medium mb-1 block">Assist By (Optional)</label>
                <select id="assist-player-select" class="w-full rounded-md border border-gray-300 p-2 text-sm">
                  <option value="">No assist</option>
                </select>
              </div>
            </div>

            <div id="card-content" class="event-content hidden">
              <div>
                <label class="text-sm font-medium mb-1 block">Card Type</label>
                <select id="card-type-select" class="w-full rounded-md border border-gray-300 p-2 text-sm">
                  <option value="">Select card type</option>
                  <option value="1">Yellow Card</option>
                  <option value="2">Red Card</option>
                  <option value="3">Second Yellow Card</option>
                </select>
              </div>
            </div>

            <div id="substitution-content" class="event-content hidden">
              <div>
                <label class="text-sm font-medium mb-1 block">Player Coming Off</label>
                <select id="player-off-select" class="w-full rounded-md border border-gray-300 p-2 text-sm">
                  <option value="">Select player coming off</option>
                </select>
              </div>
              <div class="mt-4">
                <label class="text-sm font-medium mb-1 block">Player Coming On</label>
                <select id="player-on-select" class="w-full rounded-md border border-gray-300 p-2 text-sm">
                  <option value="">Select player coming on</option>
                </select>
              </div>
            </div>

            <div class="flex justify-end gap-2">
              <button id="cancel-btn" class="hidden px-4 py-2 border border-gray-300 rounded-md text-sm font-medium flex items-center gap-1">
                <i class="ri-refresh-line text-sm"></i>
                Cancel
              </button>
              <form action="" method="POST" id="record-event-form">
                <input type="text" name="match_id" id="match_id" value="<?php echo $matchId; ?>" hidden>
                <input type="text" name="events" id="events" value="" hidden>
                <button id="record-btn" class="px-4 py-2 bg-green-500 text-white rounded-md text-sm font-medium">
                  Record Event
                </button>
              </form>
            </div>
          </div>

          <div>
            <h3 class="font-medium mb-2">Match Timeline</h3>
            <div class="h-[300px] rounded-md border p-4 overflow-y-auto scrollbar-hide" id="timeline">
              <div class="text-center text-muted-foreground py-8" id="empty-timeline">
                No events recorded yet
              </div>
              <div class="space-y-4" id="events-container">


              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    const matcheFromDb = <?php echo json_encode($match); ?>;
    console.log("matchesFromDb", matcheFromDb);
    const lineupsFromDb = <?php echo json_encode($lineups); ?>;
    console.log("lineupsFromDb", lineupsFromDb);
    const goalTypesFromDb = <?php echo json_encode($goalTypes); ?>;
    console.log("goalTypesFromDb", goalTypesFromDb);
    const goalsFromDb = <?php echo json_encode($goals); ?>;
    console.log("goalsFromDb", goalsFromDb);
    const cardsFromDb = <?php echo json_encode($cards); ?>;
    console.log("cardsFromDb", cardsFromDb);
    const substitutionsFromDb = <?php echo json_encode($substitutions); ?>;
    console.log("substitutionsFromDb", substitutionsFromDb);

    // Mock data
    const matchDetails = {
      homeTeam: {
        id: matcheFromDb.club1_id,
        name: matcheFromDb.club1_name,
        logo: matcheFromDb.club1_logo
      },
      awayTeam: {
        id: matcheFromDb.club2_id,
        name: matcheFromDb.club2_name,
        logo: matcheFromDb.club2_logo
      },
      venue: matcheFromDb.stadium_name,
      startTime: matcheFromDb.time,
      status: matcheFromDb.status
    };

    const mockPlayers = {
      homeTeam: lineupsFromDb.filter(player => player.club_type === "H").map(player => ({
        id: player.id,
        name: `${player.name} ${player.surname}`,
        number: player.number,
        position: player.position_id,
        onField: player.is_starting == 'Y' ? true : false,
        bench: player.is_starting == 'Y' ? false : true
      })),
      awayTeam: lineupsFromDb.filter(player => player.club_type === "A").map(player => ({
        id: player.id,
        name: `${player.name} ${player.surname}`,
        number: player.number,
        position: player.position_id,
        onField: player.is_starting == 'Y' ? true : false,
        bench: player.is_starting == 'Y' ? false : true
      }))
    }
    console.log("mockPlayers", mockPlayers);


    const goalTypes = goalTypesFromDb.map(type => ({
      id: type.id,
      name: type.type,
      description: type.description
    }));

    const cardTypes = [{
        id: 1,
        name: "Yellow Card",
        color: "bg-yellow-500"
      },
      {
        id: 2,
        name: "Red Card",
        color: "bg-red-600"
      },
    ];

    // State
    let matchTime = matcheFromDb.minute;

    console.log("goalsFromDb", goalsFromDb);
    const goals = goalsFromDb.map((goal) => {
      const scorrer = lineupsFromDb.find(lineup => lineup.lineup_id == goal.lineup_id);
      const team = goal.club_type == "H" ? matchDetails.homeTeam : matchDetails.awayTeam;
      const goalType = goalTypes.find(type => type.id == goal.type_id);
      const assistPlayer = goal.assistor_id ? lineupsFromDb.find(lineup => lineup.lineup_id == goal.assistor_id) : null;

      const eventDetails = {
        goalTypeId: goalType.id,
        goalTypeName: goalType.name,
      };
      if (assistPlayer) {
        eventDetails.assistPlayerId = assistPlayer.id;
        eventDetails.assistPlayerName = assistPlayer.name;
        eventDetails.assistPlayerNumber = assistPlayer.number;
      }

      return {
        id: goal.id,
        type: "GOAL",
        minute: goal.minute,
        playerId: scorrer.id,
        playerName: `${scorrer.name} ${scorrer.surname}`,
        playerNumber: scorrer.number,
        teamId: team.id,
        teamName: team.name,
        details: eventDetails,
        timestamp: new Date()
      }
    });
    console.log("goals", goals);

    const cards = cardsFromDb.map((card) => {
      const player = lineupsFromDb.find(lineup => lineup.lineup_id == card.lineup_id);
      const team = card.club_type == "H" ? matchDetails.homeTeam : matchDetails.awayTeam;
      const cardType = cardTypes.find(type => type.id == (card.type == "Y" ? 1 : 2));

      return {
        id: card.id,
        type: "CARD",
        minute: card.minute,
        playerId: player.id,
        playerName: `${player.name} ${player.surname}`,
        playerNumber: player.number,
        teamId: team.id,
        teamName: team.name,
        details: {
          cardTypeId: cardType.id,
          cardTypeName: cardType.name,
          cardColor: cardType.color
        },
        timestamp: new Date()
      }
    });

    const substitutions = substitutionsFromDb.map((sub) => {
      const playerIn = lineupsFromDb.find(lineup => lineup.lineup_id == sub.lineup_1_id);
      const playerOut = lineupsFromDb.find(lineup => lineup.lineup_id == sub.lineup_2_id);
      const team = sub.club_type == "H" ? matchDetails.homeTeam : matchDetails.awayTeam;

      return {
        id: sub.id,
        type: "SUBSTITUTION",
        minute: sub.minute,
        playerId: playerOut.id,
        playerName: `${playerOut.name} ${playerOut.surname}`,
        playerNumber: playerOut.number,
        teamId: team.id,
        teamName: team.name,
        details: {
          substitutionType: "Standard",
          playerOffId: playerOut.id,
          playerOffName: `${playerOut.name} ${playerOut.surname}`,
          playerOffNumber: playerOut.number,
          playerOnId: playerIn.id,
          playerOnName: `${playerIn.name} ${playerIn.surname}`,
          playerOnNumber: playerIn.number

        },
        timestamp: new Date()
      }
    });
    console.log("substitution", substitutions);
    let events = [...goals, ...cards,...substitutions].sort((a, b) => b.minute - a.minute);
    let eventsToSend = [];
    let selectedTeam = "homeTeam";
    let activeTab = "goal";
    let score = {
      home: goalsFromDb.filter(goal => goal.club_type == "H").length,
      away: goalsFromDb.filter(goal => goal.club_type == "A").length
    };
    console.log("score", score);
    let isEditing = null;

    // DOM Elements
    const homeTeamLogo = document.getElementById('home-team-logo');


    const homeTeamName = document.getElementById('home-team-name');
    const awayTeamLogo = document.getElementById('away-team-logo');
    const awayTeamName = document.getElementById('away-team-name');
    const homeScore = document.getElementById('home-score');
    const awayScore = document.getElementById('away-score');
    const matchTimeEl = document.getElementById('match-time');
    const teamSelect = document.getElementById('team-select');
    const playerSelect = document.getElementById('player-select');
    const assistPlayerSelect = document.getElementById('assist-player-select');
    const playerLabel = document.getElementById('player-label');
    const goalTypeSelect = document.getElementById('goal-type-select');
    const cardTypeSelect = document.getElementById('card-type-select');
    const playerOffSelect = document.getElementById('player-off-select');
    const playerOnSelect = document.getElementById('player-on-select');
    const recordBtn = document.getElementById('record-btn');
    const cancelBtn = document.getElementById('cancel-btn');
    const eventsContainer = document.getElementById('events-container');
    const emptyTimeline = document.getElementById('empty-timeline');
    const eventTabs = document.querySelectorAll('.event-tab');
    const eventContents = document.querySelectorAll('.event-content');

    // Initialize
    function init() {
      // Set team info
      homeTeamLogo.src = matchDetails.homeTeam.logo;
      homeTeamName.textContent = matchDetails.homeTeam.name;
      awayTeamLogo.src = matchDetails.awayTeam.logo;
      awayTeamName.textContent = matchDetails.awayTeam.name;
      homeScore.textContent = score.home;
      awayScore.textContent = score.away;

      // Set team options
      teamSelect.querySelector('option[value="homeTeam"]').textContent = matchDetails.homeTeam.name;
      teamSelect.querySelector('option[value="awayTeam"]').textContent = matchDetails.awayTeam.name;

      // Start match timer
      setInterval(updateMatchTime, 60000); // Update every minute

      // Populate player select
      populatePlayerSelect();
      populateAssistPlayerSelect();

      // Set active tab
      setActiveTab('goal');

      // Event listeners
      teamSelect.addEventListener('change', handleTeamChange);
      recordBtn.addEventListener('click', handleRecordEvent);
      cancelBtn.addEventListener('click', handleCancelEdit);

      // Tab event listeners
      eventTabs.forEach(tab => {
        tab.addEventListener('click', () => {
          setActiveTab(tab.dataset.tab);
        });
      });
      renderEvents();
    }

    function updateMatchTime() {
      matchTime += 1;
      matchTimeEl.textContent = formatMatchTime(matchTime);
    }

    function formatMatchTime(minutes) {
      const hours = Math.floor(minutes / 60);
      const mins = minutes % 60;
      return `${hours > 0 ? hours + 'h ' : ''}${mins}m`;
    }

    function setActiveTab(tab) {
      activeTab = tab;

      // Update tab styling
      eventTabs.forEach(t => {
        if (t.dataset.tab === tab) {
          t.classList.add('bg-green-500', 'text-white');
          t.classList.remove('text-gray-700', 'bg-gray-100');
        } else {
          t.classList.remove('bg-green-500', 'text-white');
          t.classList.add('text-gray-700', 'bg-gray-100');
        }
      });

      // Show/hide content
      eventContents.forEach(content => {
        content.classList.add('hidden');
      });

      document.getElementById(`${tab}-content`).classList.remove('hidden');

      // Update player label based on active tab
      if (tab === 'substitution') {
        populateSubstitutionSelects();
      } else {
        populatePlayerSelect();
        if (tab === 'goal') {
          populateAssistPlayerSelect();
        }
      }
    }

    function handleTeamChange() {
      selectedTeam = teamSelect.value;
      if (activeTab === 'substitution') {
        populateSubstitutionSelects();
      } else {
        populatePlayerSelect();
        if (activeTab === 'goal') {
          populateAssistPlayerSelect();
        }
      }
    }

    function populatePlayerSelect() {
      // Clear existing options except the first one
      while (playerSelect.options.length > 1) {
        playerSelect.remove(1);
      }

      // Add players from selected team who are on the field
      const players = mockPlayers[selectedTeam].filter(p => p.onField);
      console.log("players", mockPlayers[selectedTeam]);
      players.forEach(player => {
        const option = document.createElement('option');
        option.value = player.id;
        option.textContent = `${player.number} - ${player.name} (${player.position})`;
        playerSelect.appendChild(option);
      });
    }

    function populateAssistPlayerSelect() {
      // Clear existing options except the first one
      while (assistPlayerSelect.options.length > 1) {
        assistPlayerSelect.remove(1);
      }

      // Add players from selected team who are on the field
      const players = mockPlayers[selectedTeam].filter(p => p.onField);
      players.forEach(player => {
        const option = document.createElement('option');
        option.value = player.id;
        option.textContent = `${player.number} - ${player.name} (${player.position})`;
        assistPlayerSelect.appendChild(option);
      });
    }

    function populateSubstitutionSelects() {
      // Clear existing options
      while (playerOffSelect.options.length > 1) {
        playerOffSelect.remove(1);
      }
      while (playerOnSelect.options.length > 1) {
        playerOnSelect.remove(1);
      }

      // Add players from selected team
      const playersOnField = mockPlayers[selectedTeam].filter(p => p.onField);
      const playersOnBench = mockPlayers[selectedTeam].filter(p => p.bench);

      playersOnField.forEach(player => {
        const option = document.createElement('option');
        option.value = player.id;
        option.textContent = `${player.number} - ${player.name} (${player.position})`;
        playerOffSelect.appendChild(option);
      });

      playersOnBench.forEach(player => {
        const option = document.createElement('option');
        option.value = player.id;
        option.textContent = `${player.number} - ${player.name} (${player.position})`;
        playerOnSelect.appendChild(option);
      });
    }

    function handleRecordEvent(e) {
      e.preventDefault();
      const matchIdInput = document.getElementById('match_id').value;
      const eventsInput = document.getElementById('events');
      const form = document.getElementById('record-event-form');

      switch (activeTab) {
        case 'goal':
          recordGoal();
          break;
        case 'card':
          recordCard();
          break;
        case 'substitution':
          recordSubstitution();
          break;
      }

      // Update events input value
      eventsInput.value = JSON.stringify(eventsToSend);
      matchIdInput.value = matcheFromDb.id;

      form.submit();



      //
    }

    function recordGoal() {
      const playerId = playerSelect.value;
      const goalTypeId = goalTypeSelect.value;
      const assistPlayerId = assistPlayerSelect.value;

      if (!playerId || !goalTypeId) {
        alert('Please select a player and goal type');
        return;
      }

      const team = selectedTeam === "homeTeam" ? matchDetails.homeTeam : matchDetails.awayTeam;
      const player = mockPlayers[selectedTeam].find(p => p.id == playerId);
      const goalType = goalTypes.find(gt => gt.id == goalTypeId);

      if (!player || !goalType) return;

      const eventDetails = {
        goalTypeId: goalType.id,
        goalTypeName: goalType.name
      };

      // Add assist details if provided
      if (assistPlayerId) {
        const assistPlayer = mockPlayers[selectedTeam].find(p => p.id == assistPlayerId);
        if (assistPlayer) {
          eventDetails.assistPlayerId = assistPlayer.id;
          eventDetails.assistPlayerName = assistPlayer.name;
          eventDetails.assistPlayerNumber = assistPlayer.number;
        }
      }

      // Update score
      if (goalType.name === "Own Goal") {
        if (selectedTeam === "homeTeam") {
          score.away += 1;
          awayScore.textContent = score.away;
        } else {
          score.home += 1;
          homeScore.textContent = score.home;
        }
      } else {
        if (selectedTeam === "homeTeam") {
          score.home += 1;
          homeScore.textContent = score.home;
        } else {
          score.away += 1;
          awayScore.textContent = score.away;
        }
      }

      const newEvent = {
        id: Date.now().toString(),
        type: "GOAL",
        minute: matchTime,
        playerId: player.id,
        playerName: player.name,
        playerNumber: player.number,
        teamId: team.id,
        teamName: team.name,
        details: eventDetails,
        timestamp: new Date()
      };

      eventsToSend.push([{
        type: "G",
        minute: matchTime,
        lineup_player: lineupsFromDb.find(lineup => lineup.id == playerId && lineup.club_type == (selectedTeam == "homeTeam" ? "H" : "A")).lineup_id,
        goal_type: goalTypeId,
        assist_player: assistPlayerId ? lineupsFromDb.find(lineup => lineup.id == assistPlayerId && lineup.club_type == (selectedTeam == "homeTeam" ? "H" : "A")).lineup_id : null,
        isEditing_id: isEditing
      }]);



      addOrUpdateEvent(newEvent);

      // Reset selections
      playerSelect.value = "";
      goalTypeSelect.value = "";
      assistPlayerSelect.value = "";
    }

    function recordCard() {
      const playerId = playerSelect.value;
      const cardTypeId = cardTypeSelect.value;

      if (!playerId || !cardTypeId) {
        alert('Please select a player and card type');
        return;
      }

      const team = selectedTeam === "homeTeam" ? matchDetails.homeTeam : matchDetails.awayTeam;
      const player = mockPlayers[selectedTeam].find(p => p.id == playerId);
      const cardType = cardTypes.find(ct => ct.id == cardTypeId);

      if (!player || !cardType) return;

      const eventDetails = {
        cardTypeId: cardType.id,
        cardTypeName: cardType.name,
        cardColor: cardType.color
      };

      const newEvent = {
        id: Date.now().toString(),
        type: "CARD",
        minute: matchTime,
        playerId: player.id,
        playerName: player.name,
        playerNumber: player.number,
        teamId: team.id,
        teamName: team.name,
        details: eventDetails,
        timestamp: new Date()
      };

      eventsToSend.push([{
        type: "C",
        minute: matchTime,
        lineup_player: lineupsFromDb.find(lineup => lineup.id == playerId && lineup.club_type == (selectedTeam == "homeTeam" ? "H" : "A")).lineup_id,
        card_type: cardTypeId == 1 ? "Y" : "R",
        isEditing_id: isEditing
      }]);

      addOrUpdateEvent(newEvent);

      // Reset selections
      playerSelect.value = "";
      cardTypeSelect.value = "";
    }

    function recordSubstitution() {
      const playerOffId = playerOffSelect.value;
      const playerOnId = playerOnSelect.value;

      if (!playerOffId || !playerOnId) {
        alert('Please select both players for the substitution');
        return;
      }

      const team = selectedTeam === "homeTeam" ? matchDetails.homeTeam : matchDetails.awayTeam;
      const playerOff = mockPlayers[selectedTeam].find(p => p.id == playerOffId);
      const playerOn = mockPlayers[selectedTeam].find(p => p.id == playerOnId);

      if (!playerOff || !playerOn) return;

      const eventDetails = {
        substitutionType: "Standard",
        playerOffId: playerOff.id,
        playerOffName: playerOff.name,
        playerOffNumber: playerOff.number,
        playerOnId: playerOn.id,
        playerOnName: playerOn.name,
        playerOnNumber: playerOn.number
      };

      const newEvent = {
        id: Date.now().toString(),
        type: "SUBSTITUTION",
        minute: matchTime,
        playerId: playerOff.id, // We use the player coming off as the main player
        playerName: playerOff.name,
        playerNumber: playerOff.number,
        teamId: team.id,
        teamName: team.name,
        details: eventDetails,
        timestamp: new Date()
      };


      eventsToSend.push([{
        type: "S",
        minute: matchTime,
        lineup_player_out: lineupsFromDb.find(lineup => lineup.id == playerOffId && lineup.club_type == (selectedTeam == "homeTeam" ? "H" : "A")).lineup_id,
        lineup_player_in: lineupsFromDb.find(lineup => lineup.id == playerOnId && lineup.club_type == (selectedTeam == "homeTeam" ? "H" : "A")).lineup_id,
        isEditing_id: isEditing
      }]);

      addOrUpdateEvent(newEvent);

      // Update player status
      playerOff.onField = false;
      playerOff.bench = true;
      playerOn.onField = true;
      playerOn.bench = false;

      // Reset selections
      playerOffSelect.value = "";
      playerOnSelect.value = "";

      // Refresh player selects
      populateSubstitutionSelects();
    }

    function addOrUpdateEvent(newEvent) {
      if (isEditing) {
        events = events.map(event => event.id === isEditing ? newEvent : event);
        isEditing = null;
        cancelBtn.classList.add('hidden');
        recordBtn.textContent = 'Record Event';
      } else {
        events = [newEvent, ...events];
      }

      renderEvents();
    }

    function renderEvents() {
      console.log("events", events);
      if (events.length === 0) {
        emptyTimeline.classList.remove('hidden');
        eventsContainer.innerHTML = '';
        return;
      }

      emptyTimeline.classList.add('hidden');
      eventsContainer.innerHTML = '';

      events.forEach(event => {
        const eventEl = document.createElement('div');
        eventEl.className = 'flex items-start gap-3 pb-3 border-b';

        let eventContent = `
          <div class="min-w-[40px] text-center">
            <div class="bg-muted rounded-md px-2 py-1 text-xs font-medium">
              ${event.minute}'
            </div>
          </div>
          
          <div class="flex-1">
            <div class="flex items-center gap-2">
              <span class="font-medium">${event.playerName}</span>
              <span class="text-xs text-muted-foreground">#${event.playerNumber}</span>
              <span class="text-xs text-muted-foreground">(${event.teamName})</span>
            </div>
        `;

        if (event.type === "GOAL") {
          eventContent += `
            <div class="flex items-center gap-2 mt-1">
              <i class="ri-trophy-line text-amber-500"></i>
              <span class="text-sm">${event.details.goalTypeName}</span>
            </div>
          `;

          // Add assist information if available
          if (event.details.assistPlayerName) {
            eventContent += `
              <div class="flex items-center gap-2 mt-1 text-green-600">
                <i class="ri-footprint-line text-sm"></i>
                <span class="text-sm">Assist: #${event.details.assistPlayerNumber} ${event.details.assistPlayerName}</span>
              </div>
            `;
          }
        } else if (event.type === "CARD") {
          eventContent += `
            <div class="flex items-center gap-2 mt-1">
              <div class="w-4 h-5 rounded-sm ${event.details.cardColor}"></div>
              <span class="text-sm">${event.details.cardTypeName}</span>
            </div>
          `;
        } else if (event.type === "SUBSTITUTION") {
          eventContent += `
            <div class="flex items-center gap-2 mt-1">
              <i class="ri-arrow-left-right-line text-green-500"></i>
              <span class="text-sm">
                <span class="text-red-500">#${event.details.playerOffNumber} ${event.details.playerOffName}</span>
                <i class="ri-arrow-right-line mx-1"></i>
                <span class="text-green-500">#${event.details.playerOnNumber} ${event.details.playerOnName}</span>
              </span>
            </div>
          `;
        }

        eventContent += `
          </div>
          
          <div class="flex gap-1">
            <button class="h-8 w-8 rounded-md hover:bg-gray-100 flex items-center justify-center" onclick="editEvent('${event.id}')">
              <i class="ri-edit-line text-sm"></i>
            </button>
           
              
              <button type="submit" class="h-8 w-8 rounded-md hover:bg-gray-100 flex items-center justify-center text-destructive" onclick="deleteEvent('${event.id}');">
                <i class="ri-delete-bin-line text-sm"></i>
              </button>
            
          </div>
        `;

        eventEl.innerHTML = eventContent;
        eventsContainer.appendChild(eventEl);
      });
    }

    function handleCancelEdit() {
      isEditing = null;
      cancelBtn.classList.add('hidden');
      recordBtn.textContent = 'Record Event';

      // Reset selections
      playerSelect.value = "";
      goalTypeSelect.value = "";
      assistPlayerSelect.value = "";
      cardTypeSelect.value = "";
      playerOffSelect.value = "";
      playerOnSelect.value = "";
    }

    // These functions need to be global for the onclick handlers
    window.editEvent = function(eventId) {
      const event = events.find(e => e.id == eventId);
      if (!event) return;

      isEditing = eventId;
      console.log("Editing event:", event);
      cancelBtn.classList.remove('hidden');
      recordBtn.textContent = 'Update Event';

      // Set team
      selectedTeam = event.teamId === matchDetails.homeTeam.id ? "homeTeam" : "awayTeam";
      teamSelect.value = selectedTeam;

      // Set active tab based on event type
      setActiveTab(event.type.toLowerCase());

      // Populate fields based on event type
      if (event.type === "GOAL") {
        playerSelect.value = event.playerId;
        goalTypeSelect.value = event.details.goalTypeId;

        // Set assist player if available
        if (event.details.assistPlayerId) {
          assistPlayerSelect.value = event.details.assistPlayerId;
        } else {
          assistPlayerSelect.value = "";
        }
      } else if (event.type === "CARD") {
        playerSelect.value = event.playerId;
        cardTypeSelect.value = event.details.cardTypeId;
      } else if (event.type === "SUBSTITUTION") {
        playerOffSelect.value = event.details.playerOffId;
        playerOnSelect.value = event.details.playerOnId;
      }
    };

    window.deleteEvent = function(eventId) {

      const event = events.find(e => e.id == eventId);
      console.log("Deleting event:", event);
      if (!event) return;

      fetch('deleteEvents.php', {
          method: 'DELETE',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            event_id: eventId,
            event_type: event.type === "GOAL" ? "G" : event.type === "CARD" ? "C" : "S",
          })
        })
        .then(response => response.text())
        .catch(error => {
          console.error('Error:', error);
        });






      // Update score if deleting a goal
      if (event.type === "GOAL") {
        const isOwnGoal = event.details.goalTypeName === "Own Goal";
        const isHomeTeam = event.teamId === matchDetails.homeTeam.id;

        if (isOwnGoal) {
          if (isHomeTeam) {
            score.away = Math.max(0, score.away - 1);
            awayScore.textContent = score.away;
          } else {
            score.home = Math.max(0, score.home - 1);
            homeScore.textContent = score.home;
          }
        } else {
          if (isHomeTeam) {
            score.home = Math.max(0, score.home - 1);
            homeScore.textContent = score.home;
          } else {
            score.away = Math.max(0, score.away - 1);
            awayScore.textContent = score.away;
          }
        }
      }

      // If deleting a substitution, revert player statuses
      if (event.type === "SUBSTITUTION") {
        const playerOff = mockPlayers[event.teamId === matchDetails.homeTeam.id ? "homeTeam" : "awayTeam"]
          .find(p => p.id == event.details.playerOffId);
        const playerOn = mockPlayers[event.teamId === matchDetails.homeTeam.id ? "homeTeam" : "awayTeam"]
          .find(p => p.id == event.details.playerOnId);

        if (playerOff && playerOn) {
          playerOff.onField = true;
          playerOff.bench = false;
          playerOn.onField = false;
          playerOn.bench = true;

          // Refresh player selects if we're on the substitution tab
          if (activeTab === 'substitution') {
            populateSubstitutionSelects();
          }
        }
      }

      events = events.filter(e => e.id != eventId);

      console.log("events after deletion", events);
      renderEvents();


      if (isEditing === eventId) {
        handleCancelEdit();
      }


    };

    // Initialize the app
    init();
  </script>
</body>

</html>