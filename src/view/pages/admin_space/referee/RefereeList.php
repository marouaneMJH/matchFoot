<?php
require_once __DIR__ . '/../../../../controller/RefereeController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        RefereeController::update();
    } else {
        RefereeController::store();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Referee Management</title>
    <link rel="stylesheet" type="text/css" href="../../../styles/output.css">
    <link rel="stylesheet" type="text/css" href="../../../styles/menu.scss">
    <style>
        .table-container {
            overflow-x: auto;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }

        .table-row-hover:hover {
            background-color: var(--bg-color);
            transition: all 0.2s ease-in-out;
        }

        .action-button {
            transition: all 0.2s ease-in-out;
        }

        .action-button:hover {
            transform: translateY(-1px);
        }

        .custom-gradient {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        }

        .country-badge {
            background-color: var(--bg-color);
            color: var(--primary-color);
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }
    </style>
</head>
<body class="bg-[var(--bg-color)] min-h-screen">
    <div class="flex h-screen">
        <?php include __DIR__ . '/../../../components/Sidebar.php'; ?>
        
        <div class="flex-1 overflow-auto ml-72">
            <div class="p-8">
                <!-- Header Section -->
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-[var(--text-color)]">Referee Management</h1>
                        <p class="mt-1 text-[var(--primary-color)]">Manage match officials and referees</p>
                    </div>
                    
                    <button onclick="window.location.href='RefereeList.php?showModal'" 
                            class="custom-gradient hover:opacity-90 text-white px-6 py-2.5 rounded-lg flex items-center gap-2 action-button shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add New Referee
                    </button>
                </div>

                <!-- Table Section -->
                <div class="bg-white rounded-xl shadow-sm border border-[var(--secondary-color)]">
                    <?php include __DIR__ . '/RefereeForm.php'; ?>
                    
                    <div class="table-container">
                        <table class="min-w-full divide-y divide-[var(--secondary-color)]">
                            <thead class="bg-[var(--bg-color)]">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-[var(--text-color)] uppercase tracking-wider">Id</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-[var(--text-color)] uppercase tracking-wider">Last Name</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-[var(--text-color)] uppercase tracking-wider">First Name</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-[var(--text-color)] uppercase tracking-wider">Birth Date</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-[var(--text-color)] uppercase tracking-wider">Country</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-[var(--text-color)] uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-[var(--secondary-color)]">
                                <?php
                                $referees = RefereeController::index();
                                if (empty($referees)) {
                                    echo '<tr><td colspan="6" class="px-6 py-4 text-center text-[var(--primary-color)]">No referees found</td></tr>';
                                } else {
                                    foreach ($referees as $referee):
                                ?>
                                <tr class="table-row-hover">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-color)]"><?php echo $referee[Referee::$id]; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-[var(--text-color)]"><?php echo $referee[Referee::$lastName]; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-color)]"><?php echo $referee[Referee::$firstName]; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--primary-color)]"><?php echo $referee[Referee::$birthDate]; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="country-badge">
                                            <?php echo $referee['country'][Country::$name]; ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-3">
                                            <a href="RefereeList.php?id=<?php echo $referee[Referee::$id]; ?>&&showModal" 
                                               class="text-[var(--primary-color)] hover:opacity-80 action-button">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                            <a href="DeleteReferee.php?id=<?php echo $referee[Referee::$id]; ?>" 
                                               class="text-red-600 hover:text-red-800 action-button"
                                               onclick="return confirm('Are you sure you want to delete this referee?')">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
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
        document.querySelectorAll('a[href*="DeleteReferee.php"]').forEach(link => {
            link.addEventListener('click', (e) => {
                if (!confirm('Are you sure you want to delete this referee?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>
