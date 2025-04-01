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