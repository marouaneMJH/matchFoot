<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../styles/output.css">
    <title>Document</title>
</head>

<body>
    <?php include './SideBar.php'; ?>
    <!-- Main Content Area -->
    <div class="ml-72 p-8 bg-green-50 min-h-screen">
        <!-- Dashboard Header -->
        <!-- Update the Dashboard Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-green-900">Botola Pro Dashboard</h1>
            <p class="text-green-600 mt-1">Overview of Moroccan Professional Football League</p>
        </div>

        <!-- Stats Cards - Updated with Botola Pro statistics -->
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-green-600 mt-2">Botola Pro Teams</p>
            </div>

            <!-- Matches Played Card -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-green-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-600">Matches Played</p>
                        <h3 class="text-2xl font-bold text-green-900 mt-1">120</h3>
                    </div>
                    <div class="bg-green-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-green-600 mt-2">Season 2023/24</p>
            </div>

            <!-- Goals Scored Card -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-green-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-600">Goals Scored</p>
                        <h3 class="text-2xl font-bold text-green-900 mt-1">156</h3>
                    </div>
                    <div class="bg-green-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-green-600 mt-2">Total goals in Botola Pro</p>
            </div>

            <!-- Upcoming Matches Card -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-green-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-600">Upcoming Matches</p>
                        <h3 class="text-2xl font-bold text-green-900 mt-1">6</h3>
                    </div>
                    <div class="bg-green-100 p-3 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-green-600 mt-2">Next round matches</p>
            </div>
        </div>

        <!-- Recent Matches and Top Scorers Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Recent Matches -->
            <div class="bg-white rounded-xl shadow-sm border border-green-100 p-6">
                <h2 class="text-xl font-semibold text-green-900 mb-4">Recent Matches</h2>
                <div class="space-y-4">
                    <!-- Wydad vs Raja -->
                    <div class="flex items-center justify-between p-4 border border-green-100 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <img src="http://efoot/logo?file=wydad&dir=club_logo" alt="Wydad AC" class="w-8 h-8 rounded-full">
                            <span class="font-medium text-green-900">Wydad AC</span>
                            <span class="text-green-600 font-bold">2 - 1</span>
                            <span class="font-medium text-green-900">Raja CA</span>
                            <img src="http://efoot/logo?file=raja&dir=club_logo" alt="Raja CA" class="w-8 h-8 rounded-full">
                        </div>
                        <span class="text-sm text-green-600">Yesterday</span>
                    </div>

                    <!-- FAR vs FUS -->
                    <div class="flex items-center justify-between p-4 border border-green-100 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <img src="http://efoot/logo?file=far&dir=club_logo" alt="FAR Rabat" class="w-8 h-8 rounded-full">
                            <span class="font-medium text-green-900">FAR Rabat</span>
                            <span class="text-green-600 font-bold">1 - 0</span>
                            <span class="font-medium text-green-900">FUS Rabat</span>
                            <img src="http://efoot/logo?file=fus&dir=club_logo" alt="FUS Rabat" class="w-8 h-8 rounded-full">
                        </div>
                        <span class="text-sm text-green-600">2 days ago</span>
                    </div>

                    <!-- RSB vs OCK -->
                    <div class="flex items-center justify-between p-4 border border-green-100 rounded-lg">
                        <div class="flex items-center space-x-3">
                            <img src="http://efoot/logo?file=rsb&dir=club_logo" alt="RS Berkane" class="w-8 h-8 rounded-full">
                            <span class="font-medium text-green-900">RS Berkane</span>
                            <span class="text-green-600 font-bold">3 - 1</span>
                            <span class="font-medium text-green-900">Olympic Khouribga</span>
                            <img src="http://efoot/logo?file=ock&dir=club_logo" alt="Olympic Khouribga" class="w-8 h-8 rounded-full">
                        </div>
                        <span class="text-sm text-green-600">Last week</span>
                    </div>
                </div>
            </div>

            <!-- Top Scorers -->
            <div class="bg-white rounded-xl shadow-sm border border-green-100 p-6">
                <h2 class="text-xl font-semibold text-green-900 mb-4">Top Scorers</h2>
                <div class="space-y-4">
                    <!-- Scorer Items -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <img src="http://efoot/logo?file=player1&dir=player_profiles" alt="Ayoub El Kaabi" class="w-10 h-10 rounded-full">
                            <div>
                                <p class="font-medium text-green-900">Ayoub El Kaabi</p>
                                <p class="text-sm text-green-600">Wydad AC</p>
                            </div>
                        </div>
                        <div class="bg-green-100 px-3 py-1 rounded-full">
                            <span class="font-bold text-green-600">12 Goals</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <img src="http://efoot/logo?file=player2&dir=player_profiles" alt="Sofiane Rahimi" class="w-10 h-10 rounded-full">
                            <div>
                                <p class="font-medium text-green-900">Sofiane Rahimi</p>
                                <p class="text-sm text-green-600">Raja CA</p>
                            </div>
                        </div>
                        <div class="bg-green-100 px-3 py-1 rounded-full">
                            <span class="font-bold text-green-600">10 Goals</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <img src="http://efoot/logo?file=player3&dir=player_profiles" alt="Hamza Moussaoui" class="w-10 h-10 rounded-full">
                            <div>
                                <p class="font-medium text-green-900">Hamza Moussaoui</p>
                                <p class="text-sm text-green-600">FAR Rabat</p>
                            </div>
                        </div>
                        <div class="bg-green-100 px-3 py-1 rounded-full">
                            <span class="font-bold text-green-600">8 Goals</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tournament Progress -->
        <div class="bg-white rounded-xl shadow-sm border border-green-100 p-6">
            <h2 class="text-xl font-semibold text-green-900 mb-4">Botola Pro Progress</h2>
            <div class="h-4 bg-green-100 rounded-full overflow-hidden">
                <div class="h-full bg-green-500 rounded-full" style="width: 65%"></div>
            </div>
            <div class="mt-2 flex justify-between text-sm text-green-600">
                <span>Matchday 20 of 30</span>
                <span>65% Complete</span>
            </div>
            <div class="mt-4 text-sm text-green-600">
                <p>Current Season: 2023/24</p>
                <p>Remaining Matches: 10 matchdays</p>
            </div>
        </div>

        <!-- Upcoming Fixtures Preview -->


</body>

</html>