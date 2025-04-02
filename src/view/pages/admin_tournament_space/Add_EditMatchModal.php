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

        <form class="space-y-4" method="POST" action="TournamentInfos.php">
            <input type="text" id="tournamentField" name="tournamentId" class="hidden">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-green-700">Home Team</label>
                    <?php $clubs = ClubController::index(); ?>
                    <select name="club1_id" class="mt-1 block w-full rounded-md border-green-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200">
                        <option>Select Team</option>
                        <?php foreach ($clubs as $club) : ?>
                            <option value="<?php echo $club[Club::$id]; ?>"><?php echo $club[Club::$name]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-green-700">Away Team</label>
                    <?php $clubs = ClubController::index(); ?>
                    <select name="club2_id" class="mt-1 block w-full rounded-md border-green-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200">
                        <option>Select Team</option>
                        <?php foreach ($clubs as $club) : ?>
                            <option value="<?php echo $club[Club::$id]; ?>"><?php echo $club[Club::$name]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-green-700">Date</label>
                    <input name="date" type="date" class="mt-1 block w-full rounded-md border-green-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200">
                </div>
                <div>
                    <label class="block text-sm font-medium text-green-700">Time</label>
                    <input name="time" type="time" class="mt-1 block w-full rounded-md border-green-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200">
                </div>
            </div>
            <div class="flex space-x-4">
                <div class="w-full">
                    <label class="block text-sm font-medium text-green-700">Stadium</label>
                    <?php $stadiums = StadiumController::index(); ?>
                    <select name="stadium_id" class="mt-1 block w-full rounded-md border-green-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200">
                        <option>Select Stadium</option>
                        <!-- Add stadium options -->
                        <?php foreach ($stadiums as $stadium) : ?>
                            <option value="<?php echo $stadium[Stadium::$id]; ?>"><?php echo $stadium[Stadium::$name]; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="w-full">
                    <div>
                        <label class="block text-sm font-medium text-green-700">Round</label>
                        <select name="round" class="mt-1 block w-full rounded-md border-green-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200">
                            <option value="">Select Round</option>
                            <!-- Add round options -->
                            <option value="32">Round 32</option>
                            <option value="16">Round 16</option>
                            <option value="8">Quarter Finals</option>
                            <option value="4">Semi Finals</option>
                            <option value="2">Final</option>
                        </select>
                    </div>
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
    const tournamentId = localStorage.getItem('selectedTournament');
    document.getElementById('tournamentField').value = tournamentId;
</script>