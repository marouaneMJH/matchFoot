<?php
    
    

    require_once './components/Sidebar.php';
    require_once './components/HeaderNavBar.php';
    require_once './../../../model/User.php'; // Add user model inclusion
    require_once './../../../controller/AuthController.php';
    require_once './../../../helper/ImageHelper.php';
    AuthController::checkAuth();
    ob_start(); // Start output buffering
    // AuthController::checkAuth();
     AuthController::startSession();

    $headerNavbar = new HeaderNavBar('../../');
    $sidebar = new Sidebar('../../');

    // Get user data from database
    try {
        $userData = User::getUser($_SESSION['user_id']);
        
        // If user not found, redirect to login
        if (empty($userData)) {
            session_destroy();
            AuthController::redirectToLogin();
            exit();
        }
        
        // Format the date for display
        echo '<script>document.title = "'.$userData->getDisplayedName().' Profile - SoftFootBall";</script>';

        $birthDate = !empty($userData->getbirthDate()) ? date("F j, Y", strtotime($userData->getbirthDate())) : 'Not provided';
        $memberSince = date("M j, Y", strtotime($userData->getCreatedAt()));
        
        // Get profile image path
        $profileImage = Image::getImage('users_profiles',$userData->getProfilePath());
        
    } catch (PDOException $e) {
        // Handle database error
        $error = "Database error: " . $e->getMessage();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - SoftFootBall</title>
    <link rel="stylesheet" href="../../styles/accueil.css" />
    <link rel="stylesheet" href="./../../styles/output.css" />
</head>
<body class="bg-gray-50">
    <div class="flex flex-col min-h-screen">
        <!-- Header Navbar -->
        <?php echo $headerNavbar->renderHeader(); ?>

        <div class="flex h-screen">
            <!-- Main Content -->
            <?php echo $sidebar->render() ?> 
            <div class="flex-1 overflow-auto ml-272 lg:ml-0">
                <div class="p-8">
                    <!-- Page Header -->
                    <div class="mb-8">
                        <h1 class="text-3xl font-bold text-green-900">My Profile</h1>
                        <p class="text-green-600 mt-1">View and manage your account information</p>
                    </div>

                    <?php if (isset($error)): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                        <p><?php echo $error; ?></p>
                    </div>
                    <?php endif; ?>

                    <!-- Profile Content -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Profile Card -->
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-green-100 lg:col-span-1">
                            <div class="flex flex-col items-center">
                                <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-green-100 mb-4">
                                    <img src="<?php echo htmlspecialchars($profileImage); ?>" alt="Profile Picture" class="w-full h-full object-cover">
                                </div>
                                
                                <h2 class="text-xl font-bold text-green-900"><?php echo htmlspecialchars($userData->getDisplayedName()); ?></h2>
                                <p class="text-green-600">@<?php echo htmlspecialchars($userData->getUsername()); ?></p>
                                
                                <div class="mt-6 w-full">
                                    <button class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition"
                                        id="openDialog"
                                    >
                                        Edit Profile
                                    </button>
                                </div>
                                
                                <div class="mt-6 w-full pt-6 border-t border-green-100">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm text-gray-500">Member since</span>
                                        <span class="text-sm font-medium text-green-900"><?php echo $memberSince; ?></span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-500">Last login</span>
                                        <span class="text-sm font-medium text-green-900">Today, <?php echo date("g:i A"); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Profile Details -->
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-green-100 lg:col-span-2">
                            <h3 class="text-lg font-semibold text-green-900 mb-4">Account Information</h3>
                            
                            <div class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Username</label>
                                        <div class="text-green-900 font-medium"><?php echo htmlspecialchars($userData->getUsername()); ?></div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Display Name</label>
                                        <div class="text-green-900 font-medium"><?php echo htmlspecialchars($userData->getDisplayedName()); ?></div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Email Address</label>
                                        <div class="text-green-900 font-medium"><?php echo htmlspecialchars($userData->getEmail()); ?></div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Birth Date</label>
                                        <div class="text-green-900 font-medium"><?php echo $birthDate; ?></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-8 pt-6 border-t border-green-100">
                                <h3 class="text-lg font-semibold text-green-900 mb-4">Security</h3>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Password</label>
                                        <div class="text-green-900 font-medium">••••••••</div>
                                    </div>
                                    
                                    <div>
                                        <button class="bg-green-100 text-green-700 py-2 px-4 rounded-lg hover:bg-green-200 transition" id="changePasswordBtn">
                                            Change Password
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-8 pt-6 border-t border-green-100">
                                <h3 class="text-lg font-semibold text-green-900 mb-4">Recent Activity</h3>
                                
                                <!-- This section could be dynamic with a table for user_activity if available -->
                                <div class="space-y-4">
                                    <div class="flex items-start space-x-3">
                                        <div class="bg-green-100 p-2 rounded-full">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-green-900">Logged in from new device</p>
                                            <p class="text-xs text-gray-500">Today, <?php echo date("g:i A"); ?></p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start space-x-3">
                                        <div class="bg-green-100 p-2 rounded-full">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-green-900">Updated profile information</p>
                                            <p class="text-xs text-gray-500">Yesterday, 3:45 PM</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-start space-x-3">
                                        <div class="bg-green-100 p-2 rounded-full">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-green-900">Changed password</p>
                                            <p class="text-xs text-gray-500"><?php echo date("M j, Y", strtotime("-3 days")); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- edit dialog  -->
                <?php include './user_profile/UpdateProfile.php'; ?>
            </div>
        </div>
    </div>

    <script>
        // Add any JavaScript for the edit profile dialog and password change functionality
        document.addEventListener('DOMContentLoaded', function() {
            const openDialogBtn = document.getElementById('openDialog');
            
            if (openDialogBtn) {
                openDialogBtn.addEventListener('click', function() {
                    // Code to open dialog - depends on how EditProfile.php is implemented
                    // Typically this might look like:
                    const dialog = document.getElementById('editProfileDialog');
                    if (dialog) {
                        dialog.classList.remove('hidden');
                    }
                });
            }

            const changePasswordBtn = document.getElementById('changePasswordBtn');
            if (changePasswordBtn) {
                changePasswordBtn.addEventListener('click', function() {
                    // Navigate to password change page or open password change dialog
                    window.location.href = 'user_profile/ChangePassword.php';
                });
            }
        });
    </script>
</body>
</html>