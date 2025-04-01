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