<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Live Match Events Tracker</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
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
      --color-primary: 34 197 94; /* Green-500 */
      --color-primary-foreground: 255 255 255;
      --color-muted: 240 253 244; /* Green-50 */
      --color-muted-foreground: 20 83 45; /* Green-900 */
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
    <div class="bg-white rounded-lg shadow-md mb-6">
      <div class="p-4 pb-2 border-b">
        <div class="flex justify-between items-center">
          <div class="flex items-center gap-2">
            <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold text-red-500">LIVE</span>
            <h2 class="text-lg font-bold">Match Events</h2>
          </div>
          <div class="flex items-center gap-2">
            <i class="ri-time-line text-sm text-muted-foreground"></i>
            <span class="text-sm font-medium" id="match-time">0m</span>
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
            <div class="font-semibold" id="home-team-name">FC Barcelona</div>
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
              <button id="record-btn" class="px-4 py-2 bg-green-500 text-white rounded-md text-sm font-medium">
                Record Event
              </button>
            </div>
          </div>
          
          <div>
            <h3 class="font-medium mb-2">Match Timeline</h3>
            <div class="h-[300px] rounded-md border p-4 overflow-y-auto scrollbar-hide" id="timeline">
              <div class="text-center text-muted-foreground py-8" id="empty-timeline">
                No events recorded yet
              </div>
              <div class="space-y-4" id="events-container"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Mock data
    const matchDetails = {
      homeTeam: { id: 1, name: "FC Barcelona", logo: "https://via.placeholder.com/40" },
      awayTeam: { id: 2, name: "Real Madrid", logo: "https://via.placeholder.com/40" },
      venue: "Camp Nou",
      startTime: new Date(),
      status: "LIVE"
    };

    const mockPlayers = {
      homeTeam: [
        { id: 1, name: "John Smith", number: 1, position: "GK", onField: true, bench: false },
        { id: 2, name: "David Johnson", number: 4, position: "DF", onField: true, bench: false },
        { id: 3, name: "Michael Williams", number: 5, position: "DF", onField: true, bench: false },
        { id: 4, name: "James Brown", number: 8, position: "MF", onField: true, bench: false },
        { id: 5, name: "Robert Jones", number: 9, position: "FW", onField: true, bench: false },
        { id: 6, name: "Thomas Davis", number: 10, position: "FW", onField: true, bench: false },
        { id: 7, name: "Daniel Miller", number: 11, position: "FW", onField: true, bench: false },
        { id: 15, name: "William Clark", number: 12, position: "DF", onField: false, bench: true },
        { id: 16, name: "Joseph Lewis", number: 14, position: "MF", onField: false, bench: true },
        { id: 17, name: "Richard Walker", number: 16, position: "FW", onField: false, bench: true },
      ],
      awayTeam: [
        { id: 8, name: "Christopher Wilson", number: 1, position: "GK", onField: true, bench: false },
        { id: 9, name: "Matthew Moore", number: 2, position: "DF", onField: true, bench: false },
        { id: 10, name: "Anthony Taylor", number: 5, position: "DF", onField: true, bench: false },
        { id: 11, name: "Paul Anderson", number: 6, position: "MF", onField: true, bench: false },
        { id: 12, name: "Mark Thomas", number: 8, position: "MF", onField: true, bench: false },
        { id: 13, name: "Steven Jackson", number: 9, position: "FW", onField: true, bench: false },
        { id: 14, name: "Andrew White", number: 11, position: "FW", onField: true, bench: false },
        { id: 18, name: "Edward Harris", number: 13, position: "DF", onField: false, bench: true },
        { id: 19, name: "Charles Martin", number: 15, position: "MF", onField: false, bench: true },
        { id: 20, name: "Brian Thompson", number: 17, position: "FW", onField: false, bench: true },
      ]
    };

    const goalTypes = [
      { id: 1, name: "Normal Goal" },
      { id: 2, name: "Penalty" },
      { id: 3, name: "Free Kick" },
      { id: 4, name: "Header" },
      { id: 5, name: "Own Goal" }
    ];

    const cardTypes = [
      { id: 1, name: "Yellow Card", color: "bg-yellow-500" },
      { id: 2, name: "Red Card", color: "bg-red-600" },
      { id: 3, name: "Second Yellow Card", color: "bg-gradient-to-r from-yellow-500 to-red-600" }
    ];

    // State
    let matchTime = 0;
    let events = [];
    let selectedTeam = "homeTeam";
    let activeTab = "goal";
    let score = { home: 0, away: 0 };
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

    function handleRecordEvent() {
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
            <button class="h-8 w-8 rounded-md hover:bg-gray-100 flex items-center justify-center text-destructive" onclick="deleteEvent('${event.id}')">
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
      const event = events.find(e => e.id === eventId);
      if (!event) return;
      
      isEditing = eventId;
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
      const event = events.find(e => e.id === eventId);
      if (!event) return;
      
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
      
      events = events.filter(e => e.id !== eventId);
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