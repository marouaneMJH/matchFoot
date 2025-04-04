<?php
// This file is included in the main profile page

// Process form submission for profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $displayedName = $_POST['displayed_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $birthDate = $_POST['birth_date'] ?? null;
    
    // Validate inputs
    $errors = [];
    
    if (empty($displayedName)) {
        $errors[] = "Display name is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    // Handle profile image upload
    $profilePath = $userData->getProfilePath(); // Keep existing by default
    

    // upload the image if it exists
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['size'] > 0) {
        $uploadDir = '../../uploads/profiles/';
        $fileName = $_SESSION['user_id'] . '_' . time() . '_' . basename($_FILES['profile_image']['name']);
        $uploadFile = $uploadDir . $fileName;

        Image::uploadImage($_FILES['profile_image'], $uploadDir);
    }
    
    // If no errors, update profile
    if (empty($errors)) {
        try {
            $pdo = User::connect();
            $stmt = $pdo->prepare("UPDATE user SET displayed_name = :displayed_name, 
                                   email = :email, birth_date = :birth_date, 
                                   profile_path = :profile_path 
                                   WHERE id = :id");
            
            $result = $stmt->execute([
                'displayed_name' => $displayedName,
                'email' => $email,
                'birth_date' => $birthDate,
                'profile_path' => $profilePath,
                'id' => $_SESSION['user_id']
            ]);
            
            if ($result) {
                // Refresh page to show updated data
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                $errors[] = "Failed to update profile";
            }
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!-- Edit Profile Dialog -->
<div id="editProfileDialog" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-green-900">Edit Profile</h3>
            <button id="closeDialog" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <?php if (isset($errors) && !empty($errors)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
            <ul class="list-disc pl-4">
                <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="profile_image" class="block text-sm font-medium text-gray-700 mb-1">Profile Image</label>
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 rounded-full overflow-hidden border border-green-100">
                        <img src="<?php echo htmlspecialchars($profileImage); ?>" alt="Current Profile Picture" class="w-full h-full object-cover">
                    </div>
                    <input type="file" id="profile_image" name="profile_image" accept="image/*" class="text-sm text-gray-500">
                </div>
            </div>
            
            <div class="mb-4">
                <label for="displayed_name" class="block text-sm font-medium text-gray-700 mb-1">Display Name</label>
                <input type="text" id="displayed_name" name="displayed_name" 
                       value="<?php echo htmlspecialchars($userData->getDisplayedName()); ?>" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
            </div>
            
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="email" id="email" name="email" 
                       value="<?php echo htmlspecialchars($userData->getEmail()); ?>" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
            </div>
            
            <div class="mb-4">
                <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-1">Birth Date</label>
                <input type="date" id="birth_date" name="birth_date" 
                       value="<?php echo !empty($userData->getbirthDate()) ? date('Y-m-d', strtotime($userData->getbirthDate())) : ''; ?>" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500">
            </div>
            
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" id="cancelButton" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" name="update_profile" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Dialog functionality
    document.addEventListener('DOMContentLoaded', function() {
        const dialog = document.getElementById('editProfileDialog');
        const closeBtn = document.getElementById('closeDialog');
        const cancelBtn = document.getElementById('cancelButton');
        
        // Close dialog functions
        function closeDialog() {
            dialog.classList.add('hidden');
        }
        
        if (closeBtn) closeBtn.addEventListener('click', closeDialog);
        if (cancelBtn) cancelBtn.addEventListener('click', closeDialog);
        
        // Close when clicking outside the dialog
        dialog.addEventListener('click', function(e) {
            if (e.target === dialog) {
                closeDialog();
            }
        });
        
        // Show dialog if there are form errors
        <?php if (isset($errors) && !empty($errors)): ?>
        dialog.classList.remove('hidden');
        <?php endif; ?>
    });
</script>