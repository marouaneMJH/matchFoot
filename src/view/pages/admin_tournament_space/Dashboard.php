<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/output.css">
    <title>Document</title>
</head>
<body>
    <!-- Main Content Area -->
<div class="ml-72 p-8 bg-green-50 min-h-screen">
    <!-- Dashboard Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-green-900">Tournament Dashboard</h1>
        <p class="text-green-600 mt-1">Overview of tournament statistics and activities</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Teams Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-green-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-600">Total Teams</p>
                    <h3 class="text-2xl font-bold text-green-900 mt-1">16</h3>
                </div>
                <div class="bg-green-100 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-green-600 mt-2">All participating teams</p>
        </div>

        <!-- Matches Played Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-green-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-600">Matches Played</p>
                    <h3 class="text-2xl font-bold text-green-900 mt-1">24</h3>
                </div>
                <div class="bg-green-100 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-green-600 mt-2">Total matches completed</p>
        </div>

        <!-- Goals Scored Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-green-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-600">Goals Scored</p>
                    <h3 class="text-2xl font-bold text-green-900 mt-1">68</h3>
                </div>
                <div class="bg-green-100 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-green-600 mt-2">Total goals in tournament</p>
        </div>

        <!-- Upcoming Matches Card -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-green-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-600">Upcoming Matches</p>
                    <h3 class="text-2xl font-bold text-green-900 mt-1">8</h3>
                </div>
                <div class="bg-green-100 p-3 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-sm text-green-600 mt-2">Scheduled matches</p>
        </div>
    </div>

    <!-- Recent Matches and Top Scorers Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Recent Matches -->
        <div class="bg-white rounded-xl shadow-sm border border-green-100 p-6">
            <h2 class="text-xl font-semibold text-green-900 mb-4">Recent Matches</h2>
            <div class="space-y-4">
                <!-- Match Item -->
                <div class="flex items-center justify-between p-4 border border-green-100 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <img src="team1-logo.jpg" alt="Team 1" class="w-8 h-8 rounded-full">
                        <span class="font-medium text-green-900">Team A</span>
                        <span class="text-green-600 font-bold">2 - 1</span>
                        <span class="font-medium text-green-900">Team B</span>
                        <img src="team2-logo.jpg" alt="Team 2" class="w-8 h-8 rounded-full">
                    </div>
                    <span class="text-sm text-green-600">Yesterday</span>
                </div>
                <!-- Add more match items -->
            </div>
        </div>

        <!-- Top Scorers -->
        <div class="bg-white rounded-xl shadow-sm border border-green-100 p-6">
            <h2 class="text-xl font-semibold text-green-900 mb-4">Top Scorers</h2>
            <div class="space-y-4">
                <!-- Scorer Item -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <img src="player1.jpg" alt="Player 1" class="w-10 h-10 rounded-full">
                        <div>
                            <p class="font-medium text-green-900">John Doe</p>
                            <p class="text-sm text-green-600">Team A</p>
                        </div>
                    </div>
                    <div class="bg-green-100 px-3 py-1 rounded-full">
                        <span class="font-bold text-green-600">12 Goals</span>
                    </div>
                </div>
                <!-- Add more scorer items -->
            </div>
        </div>
    </div>

    <!-- Tournament Progress -->
    <div class="bg-white rounded-xl shadow-sm border border-green-100 p-6">
        <h2 class="text-xl font-semibold text-green-900 mb-4">Tournament Progress</h2>
        <div class="h-4 bg-green-100 rounded-full overflow-hidden">
            <div class="h-full bg-green-500 rounded-full" style="width: 75%"></div>
        </div>
        <div class="mt-2 flex justify-between text-sm text-green-600">
            <span>Round 3 of 4</span>
            <span>75% Complete</span>
        </div>
    </div>
</div>

</body>
</html>