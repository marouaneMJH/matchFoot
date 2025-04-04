<?php
    session_start();
    
    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        // Redirect to login page if not logged in
        header("Location: ../../login.php");
        exit();
    }

    require_once '../components/Sidebar.php';
    require_once '../components/HeaderNavBar.php';
    require_once './../../../../model/User.php';

    $headerNavbar = new HeaderNavBar('../../');
    $sidebar = new Sidebar('../../');
    
    $success = false;
    $errors = [];
    
    // Process form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        // Validate inputs
        if (empty($currentPassword)) {
            $errors[] = "Current password is required";
        }
        
        if (empty($newPassword)) {
            $errors[] = "New password is required";
        } elseif (strlen($newPassword) < 8) {
            $errors[] = "New password must be at least 8 characters long";
        }
        
        if ($newPassword !== $confirmPassword) {
            $errors[] = "New passwords do not match";
        }
        
        // If no errors, verify current password and update
        if (empty($errors)) {
            try {
                // Get current user data
                $userData = User::getUser($_SESSION['user_id']);
                
                if (empty($userData)) {
                    $errors[] = "User not found";
                } else {
                    // Verify current password
                    if (password_verify($currentPassword, $userData->password)) {
                        // Hash new password
                        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                        
                        // Update password in database
                        $pdo = User::connect();
                        $stmt = $pdo->prepare("UPDATE user SET password = :password WHERE id = :id");
                        $result = $stmt->execute([
                            'password' => $hashedPassword,
                            'id' => $_SESSION['user_id']
                        ]);
                        
                        if ($result) {
                            $success = true;
                        } else {
                            $errors[] = "Failed to update password";
                        }
                    } else {
                        $errors[] = "Current password is incorrect";
                    }
                }
            } catch (PDOException $e) {
                $errors[] = "Database error: " . $e->getMessage();
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - SoftFootBall</title>
    <link rel="stylesheet" href="../../../styles/accueil.css" />
    <link rel="stylesheet" href="../../../styles/output.css" />
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
                        <h1 class="text-3xl font-bold text-green-900">Change Password</h1>
                        <p class="text-green-600 mt-1">Update your account password</p>
                    </div>
                    
                    <?php if ($success): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                        <p>Your password has been successfully updated!</p>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($errors)): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                        <ul class="list-disc pl-4">
                            <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-green-100 max-w-md">
                        <form method="POST">
                            <div class="mb-4">
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                                <input type="password" id="current_password" name="current_password" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
                            </div>
                            
                            <div class="mb-4">
                                <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                                <input type="password" id="new_password" name="new_password" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
                                <p class="text-sm text-gray-500 mt-1">Password must be at least 8 characters long</p>
                            </div>
                            
                            <div class="mb-4">
                                <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                                <input type="password" id="confirm_password" name="confirm_password" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
                            </div>
                            
                            <div class="mt-6 flex space-x-3">
                                <button type="submit" name="change_password" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                    Update Password
                                </button>
                                <a href="../Profile.php" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>