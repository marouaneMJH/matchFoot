<?php
require_once __DIR__ . '/../../../../controller/AdminTournamentController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['id']) && !empty($_POST['id'])) {
    AdminTournamentController::update();
  } else {
    AdminTournamentController::store();
  }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  if (isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['delete_tournament']) && !empty($_GET['delete_tournament'])) {
    $id = $_GET['id'];
    $tournamentId = $_GET['delete_tournament'];
    AdminTournamentController::removeTournament($id, $tournamentId);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tournament Admin Management</title>
  <link rel="stylesheet" type="text/css" href="../../../styles/output.css">
  <link rel="stylesheet" type="text/css" href="../../../styles/menu.scss">
  <style>
    :root {
      --primary-green: #15803d;
      --hover-green: #166534;
      --light-green: #dcfce7;
      --text-green: #14532d;
    }

    .table-container {
      overflow-x: auto;
      border-radius: 0.5rem;
      box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    }

    .table-row-hover:hover {
      background-color: var(--light-green);
      transition: all 0.2s ease-in-out;
    }

    .action-button {
      transition: all 0.2s ease-in-out;
    }

    .action-button:hover {
      transform: translateY(-1px);
    }

    .green-gradient {
      background: linear-gradient(135deg, #15803d 0%, #22c55e 100%);
    }
  </style>
</head>

<body class="bg-green-50 min-h-screen">
  <div class="flex h-screen bg-green-50">
    <?php include __DIR__ . '/../../../components/Sidebar.php'; ?>

    <div class="flex-1 overflow-auto ml-72">
      <div class="p-8">
        <!-- Header Section -->
        <div class="flex justify-between items-center mb-8">
          <div>
            <h1 class="text-3xl font-bold text-green-900">Tournament Admin Management</h1>
            <p class="text-green-600 mt-1">Manage tournament administrators and their assignments</p>
          </div>

          <button onclick="window.location.href='AdminTournamentList.php?showModal'"
            class="green-gradient hover:bg-green-800 text-white px-6 py-2.5 rounded-lg flex items-center gap-2 action-button shadow-lg shadow-green-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add New Admin
          </button>
        </div>

        <!-- Search and Filter Section -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-green-100 mb-6">
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Search Bar -->
            <div class="col-span-1 md:col-span-2">
              <div class="relative">
                <input type="text"
                  id="searchInput"
                  placeholder="Search administrators..."
                  class="w-full pl-10 pr-4 py-2.5 border border-green-200 rounded-lg focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500">
                <svg class="w-5 h-5 text-green-500 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
            </div>

            <!-- Filter Dropdowns -->
            <div>
              <select id="roleFilter" class="w-full p-2.5 border border-green-200 rounded-lg focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 text-green-800">
                <option value="">Filter by Role</option>
                <option value="admin">Admin</option>
                <option value="supervisor">Supervisor</option>
              </select>
            </div>

            <div>
              <select id="statusFilter" class="w-full p-2.5 border border-green-200 rounded-lg focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 text-green-800">
                <option value="">Filter by Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white rounded-xl shadow-sm border border-green-100">
          <?php include __DIR__ . '/AdminTournamentForm.php'; ?>

          <div class="table-container">
            <table class="min-w-full divide-y divide-green-200">
              <thead class="bg-green-50">
                <tr>
                  <th class="px-6 py-4 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Id</th>
                  <th class="px-6 py-4 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Profile</th>
                  <th class="px-6 py-4 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Last Name</th>
                  <th class="px-6 py-4 text-left text-xs font-medium text-green-700 uppercase tracking-wider">First Name</th>
                  <th class="px-6 py-4 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Email</th>
                  <th class="px-6 py-4 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Birth Date</th>
                  <th class="px-6 py-4 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Phone</th>
                  <th class="px-6 py-4 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Created At</th>
                  <th class="px-6 py-4 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Actions</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-green-100">
                <?php
                $adminTournements = AdminTournamentController::index();
                if (empty($adminTournements)) {
                  echo '<tr><td colspan="9" class="px-6 py-4 text-center text-green-500">No tournament administrators found</td></tr>';
                } else {
                  foreach ($adminTournements as $adminTournement):
                ?>
                    <tr class="table-row-hover">
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-green-900"><?php echo $adminTournement[Admin::$id]; ?></td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <img class="h-10 w-10 rounded-full object-cover border-2 border-green-200"
                          src="<?php echo $adminTournement['profile']; ?>"
                          alt="Admin Profile">
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-900"><?php echo $adminTournement[Admin::$lastName]; ?></td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600"><?php echo $adminTournement[Admin::$firstName]; ?></td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600"><?php echo $adminTournement[Admin::$email]; ?></td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600"><?php echo $adminTournement[Admin::$birthDate]; ?></td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600"><?php echo $adminTournement[Admin::$phoneNumber]; ?></td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600"><?php echo $adminTournement[Admin::$createdAt]; ?></td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-3">
                          <a href="AdminTournamentList.php?id=<?php echo $adminTournement[Admin::$id]; ?>&&showModal"
                            class="text-green-600 hover:text-green-800 action-button">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                          </a>
                          <a href="DeleteAdminTournament.php?id=<?php echo $adminTournement[Admin::$id]; ?>"
                            class="text-red-600 hover:text-red-800 action-button"
                            onclick="return confirm('Are you sure you want to delete this administrator?')">

                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                          </a>
                        </div>
                      </td>
                    </tr>
                <?php
                  endforeach;
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
      const searchValue = this.value.toLowerCase();
      const rows = document.querySelectorAll('tbody tr');

      rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchValue) ? '' : 'none';
      });
    });

    // Filter functionality
    function applyFilters() {
      const roleFilter = document.getElementById('roleFilter').value.toLowerCase();
      const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
      const rows = document.querySelectorAll('tbody tr');

      rows.forEach(row => {
        const roleMatch = !roleFilter || row.querySelector('[data-role]').dataset.role.toLowerCase() === roleFilter;
        const statusMatch = !statusFilter || row.querySelector('[data-status]').dataset.status.toLowerCase() === statusFilter;
        row.style.display = roleMatch && statusMatch ? '' : 'none';
      });
    }

    // Add event listeners to filters
    document.getElementById('roleFilter').addEventListener('change', applyFilters);
    document.getElementById('statusFilter').addEventListener('change', applyFilters);

    // Delete confirmation
    function confirmDelete(event) {
      if (!confirm('Are you sure you want to delete this administrator?')) {
        event.preventDefault();
      }
    }

    // Add click event listeners to delete buttons
    document.querySelectorAll('a[href*="DeleteAdminTournament.php"]').forEach(link => {
      link.addEventListener('click', confirmDelete);
    });
  </script>
</body>

</html>