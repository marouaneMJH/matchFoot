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
                                    src="http://efoot/logo?file=wydad&dir=club_logo"
                                    alt="Wydad AC">
                                <div>
                                    <div class="text-sm font-medium text-green-900">Wydad AC</div>
                                    <div class="text-sm text-green-600">Botola Pro</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-green-900">Mohammed V Complex</div>
                            <div class="text-sm text-green-600">Capacity: 45,000</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-green-900">1937</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-green-900">Adil Ramzi</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                28 Players
                            </span>
                        </td>
                        <!-- Rest of the club row structure remains the same -->
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
                    <!-- Add more Moroccan club rows following the same structure -->
            </table>
        </div>
    </div>
</div>
<!-- Add Club Modal -->
 <?php include_once 'AddClubModal.php'; ?>