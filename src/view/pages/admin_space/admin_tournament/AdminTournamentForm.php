<?php
require_once __DIR__ . '/../../../../controller/TournamentController.php';
$adminTournamentId = '';
$adminTournamentFirstName = '';
$adminTournamentLastName = '';
$adminTournamentBirthDay = '';
$adminTournamentEmail = '';
$adminTournamentPhoneNumber = '';
$adminTournamentPassword = '';
$tournamentsAdmin = [];
$tournamentsAdmin = [];
$is_update = false;


$tournaments = TournamentController::index();

if (isset($_GET['id'])) {
    $adminTournamentId = $_GET['id'];
    $adminTournament = AdminTournamentController::getAdminTournamentById($adminTournamentId);
    $adminTournamentFirstName = $adminTournament[Admin::$firstName];
    $adminTournamentLastName = $adminTournament[Admin::$lastName];
    $adminTournamentBirthDay = $adminTournament[Admin::$birthDate];
    $adminTournamentEmail = $adminTournament[Admin::$email];
    $adminTournamentPassword = $adminTournament[Admin::$password];
    $adminTournamentPhoneNumber = $adminTournament[Admin::$phoneNumber];
    $tournamentsAdmin = TournamentController::getTournamentsByAdminId($adminTournamentId);
    $is_update = true;
}
?>

<?php
// ... PHP code remains the same until the dialog ...
?>

<dialog id="clubModal" class="p-8 w-[40rem] bg-white shadow-xl rounded-lg mx-auto my-auto">
    <form action="AdminTournamentList.php" method="post" id="adminTournamentForm" enctype="multipart/form-data" class="space-y-6">
        <!-- Form Header -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-[var(--text-color)]">
                <?php echo $is_update ? 'Update Tournament Admin' : 'Create Tournament Admin'; ?>
            </h2>
            <p class="text-[var(--primary-color)] mt-1">
                <?php echo $is_update ? 'Modify existing administrator details' : 'Add a new tournament administrator'; ?>
            </p>
        </div>

        <input type="text" name="id" value="<?php echo $adminTournamentId; ?>" hidden />

        <!-- Personal Information Section -->
        <div class="space-y-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-[var(--text-color)] mb-1" for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" value="<?php echo $adminTournamentFirstName; ?>"
                        class="w-full px-4 py-2.5 border border-[var(--secondary-color)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] transition-colors"
                        required />
                </div>
                <div>
                    <label class="block text-sm font-medium text-[var(--text-color)] mb-1" for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" value="<?php echo $adminTournamentLastName; ?>"
                        class="w-full px-4 py-2.5 border border-[var(--secondary-color)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] transition-colors"
                        required />
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-[var(--text-color)] mb-1" for="birth_date">Date of Birth</label>
                    <input type="date" dateformat="yyyy-mm-dd" name="birth_date" id="birth_date" 
                        value="<?php echo $adminTournamentBirthDay; ?>"
                        class="w-full px-4 py-2.5 border border-[var(--secondary-color)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] transition-colors"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-[var(--text-color)] mb-1" for="phone_number">Phone Number</label>
                    <input name="phone_number" id="phone_number" value="<?php echo $adminTournamentPhoneNumber; ?>"
                        class="w-full px-4 py-2.5 border border-[var(--secondary-color)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] transition-colors"
                        required>
                </div>
            </div>

            <!-- Informations sur le compte Section -->
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-[var(--text-color)] mb-1" for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo $adminTournamentEmail; ?>"
                        class="w-full px-4 py-2.5 border border-[var(--secondary-color)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] transition-colors"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-[var(--text-color)] mb-1" for="password">Password</label>
                    <input type="password" name="password" id="password" value="<?php echo $adminTournamentPassword; ?>"
                        class="w-full px-4 py-2.5 border border-[var(--secondary-color)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] transition-colors"
                        required>
                </div>
            </div>

            <!-- Profile Image Section -->
            <div>
                <label class="block text-sm font-medium text-[var(--text-color)] mb-1" for="image">Profile Image</label>
                <input type="file" id="image" name="profile_path"
                    class="w-full px-4 py-2.5 border border-[var(--secondary-color)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] transition-colors file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[var(--primary-color)] file:text-white hover:file:bg-[var(--secondary-color)]" />
            </div>

            <!-- Tournaments Section -->
            <div class="space-y-4">
                <label class="block text-sm font-medium text-[var(--text-color)] mb-1" for="role">Tournaments</label>
                <div class="flex items-center space-x-2">
                    <select name="tournaments" id="tournament" 
                        class="w-full px-4 py-2.5 border border-[var(--secondary-color)] rounded-lg focus:outline-none focus:ring-2 focus:ring-[var(--primary-color)] focus:border-[var(--primary-color)] transition-colors"
                        required>
                        <option value="-1" default disabled selected>Select Tournament</option>
                        <?php foreach ($tournaments as $tournament): ?>
                            <option value="<?php echo $tournament[Tournament::$id]; ?>">
                                <?php echo $tournament[Tournament::$name]; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="button" 
                        class="custom-gradient px-6 py-2.5 text-white rounded-lg hover:opacity-90 transition-opacity flex items-center gap-2"
                        id="addTournament">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add
                    </button>
                </div>

                <!-- Tournaments Table -->
                <div class="border border-[var(--secondary-color)] rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-[var(--secondary-color)]">
                        <thead class="bg-[var(--bg-color)]">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-[var(--text-color)] uppercase tracking-wider">Id</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-[var(--text-color)] uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-[var(--text-color)] uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tournaments_table" class="bg-white divide-y divide-[var(--secondary-color)]">
                            <?php foreach ($tournamentsAdmin as $tournamentAdmin): ?>
                                <tr class="hover:bg-[var(--bg-color)] transition-colors">
                                    <input type="hidden" name="tournaments[]" value="<?php echo $tournamentAdmin[Tournament::$id] ?>">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-color)]">
                                        <?php echo $tournamentAdmin[Tournament::$id]; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-color)]">
                                        <?php echo $tournamentAdmin[Tournament::$name]; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="AdminTournamentList.php?id=<?php echo $adminTournamentId ?>&delete_tournament=<?php echo $tournamentAdmin[Tournament::$id] ?>&&showModal" 
                                           class="text-red-600 hover:text-red-800 transition-colors inline-flex items-center">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end space-x-4 pt-6 border-t border-[var(--secondary-color)]">
            <a href="AdminTournamentList.php"
               id="closeModal"
               class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                Cancel
            </a>
            <button type="submit"
                    name="submit"
                    class="custom-gradient px-6 py-2.5 text-white rounded-lg hover:opacity-90 transition-opacity">
                <?php echo $is_update ? 'Update' : 'Create'; ?>
            </button>
        </div>
    </form>
</dialog>

<style>
    .custom-gradient {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    }

    
    dialog::backdrop {
        background-color: rgba(0, 0, 0, 0.5);
    }

    .file-input-wrapper {
        position: relative;
        overflow: hidden;
    }

    .file-input-wrapper input[type="file"] {
        cursor: pointer;
    }

    .file-input-wrapper:hover {
        opacity: 0.9;
    }
</style>

<script>
    const modal = document.getElementById("clubModal");
    const addTournament = document.getElementById("addTournament");

    addTournament.addEventListener("click", () => {
        const select = document.getElementById("tournament");
        const option = select.options[select.selectedIndex];
        const tournamentId = option.value;
        const tournamentName = option.text;
        
        if (tournamentId === "-1") return;

        const table = document.getElementById("tournaments_table");
        const row = document.createElement("tr");
        row.className = "hover:bg-[var(--bg-color)] transition-colors";
        row.innerHTML = `
            <input type="hidden" name="tournaments[]" value="${tournamentId}">
            <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-color)]">${tournamentId}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-color)]">${tournamentName}</td>
            <td class="px-6 py-4 whitespace-nowrap">
                <button class="text-red-600 hover:text-red-800 transition-colors delete-tournament inline-flex items-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </td>
        `;
        
        // Add click event for the delete button
        const deleteButton = row.querySelector('.delete-tournament');
        deleteButton.addEventListener('click', () => {
            row.remove();
        });

        table.appendChild(row);
        select.selectedIndex = 0; // Reset select to default option
    });

    // Add delete functionality to existing tournament rows
    document.querySelectorAll('.delete-tournament').forEach(button => {
        button.addEventListener('click', () => {
            button.closest('tr').remove();
        });
    });

    // Close modal on backdrop click
    modal.addEventListener('click', (e) => {
        const dialogDimensions = modal.getBoundingClientRect();
        if (
            e.clientX < dialogDimensions.left ||
            e.clientX > dialogDimensions.right ||
            e.clientY < dialogDimensions.top ||
            e.clientY > dialogDimensions.bottom
        ) {
            modal.close();
        }
    });

    // Form validation
    const form = document.getElementById('adminTournamentForm');
    form.addEventListener('submit', (e) => {
        const tournaments = form.querySelectorAll('input[name="tournaments[]"]');
        if (tournaments.length === 0) {
            e.preventDefault();
            alert('Please add at least one tournament');
        }
    });

    // Prevent form submission when pressing Enter in select
    document.getElementById('tournament').addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
        }
    });
</script>

<?php
if (isset($_GET['showModal'])) {
    echo '<script>modal.showModal();</script>';
}
?>
