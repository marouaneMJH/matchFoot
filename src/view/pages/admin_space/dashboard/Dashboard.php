<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../../../styles/output.css">
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Include Sidebar -->
        <?php include __DIR__ . '/../../../components/Sidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto ml-72">
            <div class="p-8">
                <!-- Dashboard Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-green-900">Admin Dashboard</h1>
                    <p class="text-green-600 mt-1">Welcome to the SoftFootBall management system</p>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Tournaments Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-green-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-green-600">Total Tournaments</p>
                                <h3 class="text-2xl font-bold text-green-900 mt-1">8</h3>
                            </div>
                            <div class="bg-green-100 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm text-green-600 mt-2">Active tournaments</p>
                    </div>

                    <!-- Teams Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-green-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-green-600">Total Teams</p>
                                <h3 class="text-2xl font-bold text-green-900 mt-1">24</h3>
                            </div>
                            <div class="bg-green-100 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm text-green-600 mt-2">Registered teams</p>
                    </div>

                    <!-- Players Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-green-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-green-600">Total Players</p>
                                <h3 class="text-2xl font-bold text-green-900 mt-1">352</h3>
                            </div>
                            <div class="bg-green-100 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm text-green-600 mt-2">Active players</p>
                    </div>

                    <!-- Stadiums Card -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-green-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-green-600">Total Stadiums</p>
                                <h3 class="text-2xl font-bold text-green-900 mt-1">12</h3>
                            </div>
                            <div class="bg-green-100 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm text-green-600 mt-2">Available venues</p>
                    </div>
                </div>

                <!-- Recent Activity and Quick Actions -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- Recent Activity -->
                    <div class="bg-white rounded-xl shadow-sm border border-green-100 p-6">
                        <h2 class="text-xl font-semibold text-green-900 mb-4">Recent Activity</h2>
                        <div class="space-y-4">
                            <!-- Activity Item -->
                            <div class="flex items-center space-x-4">
                                <div class="bg-green-100 p-2 rounded-lg">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-green-900">New tournament created</p>
                                    <p class="text-xs text-green-600">2 hours ago</p>
                                </div>
                            </div>
                            <!-- Add more activity items -->
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-xl shadow-sm border border-green-100 p-6">
                        <h2 class="text-xl font-semibold text-green-900 mb-4">Quick Actions</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="../tournament/TournamentList.php?showModal" 
                               class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                                <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                <span class="text-sm font-medium text-green-900">New Tournament</span>
                            </a>
                            
                            <a href="../club/ClubList.php?showModal" 
                               class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                                <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                <span class="text-sm font-medium text-green-900">Add Team</span>
                            </a>
                            
                            <a href="../player/PlayerList.php?showModal" 
                               class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                                <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                <span class="text-sm font-medium text-green-900">Add Player</span>
                            </a>
                            
                            <a href="../referee/RefereeList.php?showModal" 
                               class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                                <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                <span class="text-sm font-medium text-green-900">Add Referee</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
