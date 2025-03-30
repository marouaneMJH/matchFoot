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
                                <div class="text-sm font-medium text-green-900">Casablanca Derby: Wydad vs Raja Preview</div>
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
 <?php include 'Add_EditNewsModal.php'; ?>

</div>