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
        <?php include __DIR__ . '/Test.php'; ?>

        <div class="flex-1 overflow-auto ml-72">
            <div class="p-8">
                <!-- Header Section -->
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-green-900">Premier League 2023</h1>
                        <p class="text-green-600 mt-1">Tournament Management Dashboard</p>
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
                <div id="matchesTab" class="space-y-6">
                    <!-- Round Section -->
                    <div class="bg-white rounded-xl shadow-sm border border-green-100 p-6">
                        <h2 class="text-xl font-semibold text-green-900 mb-4">Round 1</h2>
                        <div class="space-y-4">
                            <!-- Match Card -->
                            <div class="border border-green-100 rounded-lg p-4 hover:bg-green-50 transition-colors">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4 flex-1">
                                        <img src="team1-logo.jpg" alt="Team 1" class="w-12 h-12 rounded-full object-cover">
                                        <span class="text-green-900 font-medium">Manchester United</span>
                                        <span class="text-2xl font-bold text-green-800">2</span>
                                    </div>
                                    <div class="px-4 py-1 rounded bg-green-100 text-green-800">
                                        VS
                                    </div>
                                    <div class="flex items-center space-x-4 flex-1 justify-end">
                                        <span class="text-2xl font-bold text-green-800">1</span>
                                        <span class="text-green-900 font-medium">Liverpool</span>
                                        <img src="team2-logo.jpg" alt="Team 2" class="w-12 h-12 rounded-full object-cover">
                                    </div>
                                    <div class="ml-4 flex items-center space-x-2">
                                        <button onclick="editMatch(1)" class="text-green-600 hover:text-green-800">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-2 text-sm text-green-600">
                                    Date: 2023-12-01 | Time: 20:00 | Stadium: Old Trafford
                                </div>
                            </div>
                            <!-- Add more match cards here -->
                        </div>
                    </div>
                </div>

                <!-- Standings Tab Content -->
                <div id="standingsTab" class="hidden">
                    <div class="bg-white rounded-xl shadow-sm border border-green-100 overflow-hidden">
                        <table class="min-w-full divide-y divide-green-200">
                            <thead class="bg-green-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Position</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Team</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Played</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Won</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Drawn</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Lost</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">GF</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">GA</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">GD</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Points</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-green-100">
                                <!-- Example team row -->
                                <tr class="hover:bg-green-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-900">1</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <img class="h-8 w-8 rounded-full" src="team-logo.jpg" alt="">
                                            <span class="ml-2 text-sm font-medium text-green-900">Manchester United</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">10</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">7</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">2</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">1</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">22</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">10</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">+12</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-900">23</td>
                                </tr>
                                <!-- Add more team rows here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Clubs Tab Content -->
            <div id="clubsTab" class="hidden">
                <div class="bg-white rounded-xl shadow-sm border border-green-100">
                    <div class="p-6 border-b border-green-100">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-xl font-semibold text-green-900">Participating Clubs</h2>
                                <p class="text-green-600 mt-1">Manage clubs participating in the tournament</p>
                            </div>
                            <button onclick="openAddClubModal()"
                                class="green-gradient hover:bg-green-800 text-white px-6 py-2.5 rounded-lg flex items-center gap-2 action-button shadow-lg shadow-green-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Add Club
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-green-200">
                            <thead class="bg-green-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Club</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Stadium</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Founded</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Coach</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Players</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-green-100">
                                <!-- Example Club Row -->
                                <tr class="hover:bg-green-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-4">
                                            <img class="h-10 w-10 rounded-full object-cover border-2 border-green-200"
                                                src="team1-logo.jpg"
                                                alt="Club Logo">
                                            <div>
                                                <div class="text-sm font-medium text-green-900">Manchester United</div>
                                                <div class="text-sm text-green-600">Premier League</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-green-900">Old Trafford</div>
                                        <div class="text-sm text-green-600">Capacity: 74,140</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-green-900">1878</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-green-900">Erik ten Hag</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            26 Players
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-3">
                                            <button class="text-green-600 hover:text-green-900 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <button class="text-red-600 hover:text-red-900 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Add more club rows here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Add Club Modal -->
            <div id="addClubModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
                <div class="bg-white rounded-xl shadow-xl w-full max-w-lg mx-4 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-green-900">Add Club to Tournament</h2>
                            <p class="text-green-600 mt-1">Select a club to add to the tournament</p>
                        </div>
                        <button onclick="closeAddClubModal()" class="text-green-600 hover:text-green-800">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-1">Select Club</label>
                            <select class="w-full px-4 py-2.5 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                <option value="">Choose a club</option>
                                <!-- Add club options dynamically -->
                            </select>
                        </div>

                        <div class="flex justify-end space-x-3 pt-4 border-t border-green-100">
                            <button type="button" onclick="closeAddClubModal()"
                                class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                                Cancel
                            </button>
                            <button type="submit"
                                class="green-gradient px-6 py-2.5 text-white rounded-lg hover:opacity-90">
                                Add Club
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div id="newsTab" class="hidden space-y-6">
                <!-- News Header -->
                <div class="bg-white rounded-xl shadow-sm border border-green-100 p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-xl font-semibold text-green-900">Tournament News</h2>
                            <p class="text-green-600 mt-1">Manage and publish tournament news and updates</p>
                        </div>
                        <button onclick="openAddNewsModal()"
                            class="green-gradient hover:bg-green-800 text-white px-6 py-2.5 rounded-lg flex items-center gap-2 action-button shadow-lg shadow-green-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Create News
                        </button>
                    </div>
                </div>

                <!-- News List -->
                <div class="bg-white rounded-xl shadow-sm border border-green-100">
                    <div class="overflow-hidden">
                        <table class="min-w-full divide-y divide-green-200">
                            <thead class="bg-green-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Title</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Published</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-green-100">
                                <!-- Example News Row -->
                                <tr class="hover:bg-green-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12">
                                                <img class="h-12 w-12 rounded-lg object-cover" src="news-image.jpg" alt="">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-green-900">Quarter Finals Schedule Announced</div>
                                                <div class="text-sm text-green-500">By Admin • 2 hours ago</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                            Schedule
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-900">
                                        Dec 15, 2023
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Published
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-3">
                                            <button class="text-green-600 hover:text-green-900 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                            <button class="text-blue-600 hover:text-blue-900 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <button class="text-red-600 hover:text-red-900 transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Add more news rows here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Add/Edit News Modal -->
            <div id="newsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
                <div class="bg-white rounded-xl shadow-xl w-full max-w-4xl mx-4 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-green-900">Create News Article</h2>
                            <p class="text-green-600 mt-1">Share updates about the tournament</p>
                        </div>
                        <button onclick="closeNewsModal()" class="text-green-600 hover:text-green-800">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-1">Title</label>
                            <input type="text"
                                class="w-full px-4 py-2.5 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                placeholder="Enter news title">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-green-700 mb-1">Category</label>
                                <select class="w-full px-4 py-2.5 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    <option value="schedule">Schedule</option>
                                    <option value="results">Results</option>
                                    <option value="announcements">Announcements</option>
                                    <option value="highlights">Highlights</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-green-700 mb-1">Status</label>
                                <select class="w-full px-4 py-2.5 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    <option value="draft">Draft</option>
                                    <option value="published">Published</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-1">Featured Image</label>
                            <input type="file"
                                class="w-full px-4 py-2.5 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-green-700 mb-1">Content</label>
                            <textarea rows="6"
                                class="w-full px-4 py-2.5 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                placeholder="Write your news content here..."></textarea>
                        </div>

                        <div class="flex justify-end space-x-3 pt-6 border-t border-green-100">
                            <button type="button" onclick="closeNewsModal()"
                                class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                                Cancel
                            </button>
                            <button type="submit"
                                class="green-gradient px-6 py-2.5 text-white rounded-lg hover:opacity-90">
                                Publish News
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Add/Edit Match Modal -->
    <div id="matchModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl mx-4 p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-green-900">Add New Match</h2>
                <button onclick="closeMatchModal()" class="text-green-600 hover:text-green-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-green-700">Home Team</label>
                        <select class="mt-1 block w-full rounded-md border-green-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200">
                            <option>Select Team</option>
                            <!-- Add team options -->
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-green-700">Away Team</label>
                        <select class="mt-1 block w-full rounded-md border-green-300 shadow-sm
                         focus:border-green-500 focus:ring focus:ring-green-200">
                            <option>Select Team</option>
                            <!-- Add team options -->
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-green-700">Date</label>
                        <input type="date" class="mt-1 block w-full rounded-md border-green-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-green-700">Time</label>
                        <input type="time" class="mt-1 block w-full rounded-md border-green-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-green-700">Stadium</label>
                    <select class="mt-1 block w-full rounded-md border-green-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200">
                        <option>Select Stadium</option>
                        <!-- Add stadium options -->
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-green-700">Round</label>
                        <select class="mt-1 block w-full rounded-md border-green-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200">
                            <option>Select Round</option>
                            <!-- Add round options -->
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-green-700">Referee</label>
                        <select class="mt-1 block w-full rounded-md border-green-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200">
                            <option>Select Referee</option>
                            <!-- Add referee options -->
                        </select>
                    </div>
                </div>

                <!-- Score section (visible only when editing) -->
                <div id="scoreSection" class="hidden">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-green-700">Home Team Score</label>
                            <input type="number" min="0" class="mt-1 block w-full rounded-md border-green-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-green-700">Away Team Score</label>
                            <input type="number" min="0" class="mt-1 block w-full rounded-md border-green-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeMatchModal()"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Save Match
                    </button>
                </div>
            </form>
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