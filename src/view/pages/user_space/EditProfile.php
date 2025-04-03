<!-- Edit Profile Dialog -->
<dialog id="editProfileDialog" class="rounded-lg shadow-xl max-w-4xl w-full bg-white">
    <div class="absolute top-4 right-4">
        <button id="closeDialog" class="text-gray-500 hover:text-gray-700 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    
    <h2 class="text-2xl font-bold text-green-800 p-6 pb-0">Edit Profile</h2>
    
    <!-- Dialog Content -->
    <form method="dialog" class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Profile Image Section -->
            <div class="md:col-span-1">
                <div class="flex flex-col items-center space-y-4">
                    <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-green-100">
                        <img id="profile-preview" class="w-full h-full object-cover" 
                                src="/api/placeholder/200/200" alt="Profile picture">
                    </div>
                    <div class="flex flex-col items-center space-y-2">
                        <label for="profile_path" 
                                class="text-sm font-medium text-green-600 bg-green-50 py-2 px-4 rounded-lg hover:bg-green-100 cursor-pointer transition">
                            Change Photo
                            <input type="file" id="profile_path" name="profile_path" accept="image/*" class="hidden">
                        </label>
                        <button type="button" class="text-sm font-medium text-red-600 hover:text-red-800">
                            Remove Photo
                        </button>
                    </div>
                </div>
            </div>

            <!-- Form Fields -->
            <div class="md:col-span-2 space-y-6">
                <!-- Account Information -->
                <div>
                    <h3 class="text-lg font-semibold text-green-900 mb-4">Account Information</h3>
                    
                    <div class="space-y-4">
                        <!-- Username (Read-only) -->
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-500 mb-1">Username</label>
                            <input type="text" id="username" name="username" readonly 
                                    class="w-full px-3 py-2 bg-gray-50 border border-green-200 rounded-lg text-green-900 cursor-not-allowed"
                                    value="johndoe">
                            <p class="mt-1 text-xs text-gray-500">Username cannot be changed</p>
                        </div>

                        <!-- Display Name -->
                        <div>
                            <label for="displayed_name" class="block text-sm font-medium text-gray-500 mb-1">Display Name</label>
                            <input type="text" id="displayed_name" name="displayed_name" required
                                    class="w-full px-3 py-2 border border-green-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-green-900"
                                    value="John Doe">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-500 mb-1">Email Address</label>
                            <input type="email" id="email" name="email" required
                                    class="w-full px-3 py-2 border border-green-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-green-900"
                                    value="john.doe@example.com">
                        </div>

                        <!-- Birth Date -->
                        <div>
                            <label for="birth_date" class="block text-sm font-medium text-gray-500 mb-1">Birth Date</label>
                            <input type="date" id="birth_date" name="birth_date"
                                    class="w-full px-3 py-2 border border-green-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-green-900"
                                    value="1985-04-12">
                        </div>
                    </div>
                </div>

                <!-- Security Section -->
                <div class="pt-6 border-t border-green-100">
                    <h3 class="text-lg font-semibold text-green-900 mb-4">Security</h3>
                    
                    <div class="space-y-4">
                        <!-- Current Password -->
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-500 mb-1">Current Password</label>
                            <input type="password" id="current_password" name="current_password"
                                    class="w-full px-3 py-2 border border-green-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                                    placeholder="Enter current password to confirm changes">
                        </div>

                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-500 mb-1">New Password</label>
                            <input type="password" id="password" name="password"
                                    class="w-full px-3 py-2 border border-green-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                                    placeholder="Leave blank to keep current password">
                            <p class="mt-1 text-xs text-gray-500">At least 8 characters with letters, numbers and symbols</p>
                        </div>

                        <!-- Confirm New Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-500 mb-1">Confirm New Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="w-full px-3 py-2 border border-green-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                                    placeholder="Leave blank to keep current password">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-green-100">
            <button type="button" id="cancelButton" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500">
                Cancel
            </button>
            <button type="submit" value="save" class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                Save Changes
            </button>
        </div>
    </form>
</dialog>


<script>
    // Get dialog element
    const dialog = document.getElementById('editProfileDialog');
    const openButton = document.getElementById('openDialog');
    const closeButton = document.getElementById('closeDialog');
    const cancelButton = document.getElementById('cancelButton');
    
    // Apply backdrop styles to the dialog
    dialog.addEventListener('close', () => {
        document.body.classList.remove('overflow-hidden');
    });
    
    // Open dialog
    openButton.addEventListener('click', () => {
        dialog.showModal();
        document.body.classList.add('overflow-hidden');
    });
    
    // Close dialog when X button is clicked
    closeButton.addEventListener('click', () => {
        if (confirm('Are you sure you want to close? Any unsaved changes will be lost.')) {
            dialog.close();
        }
    });
    
    // Close dialog when Cancel button is clicked
    cancelButton.addEventListener('click', () => {
        if (confirm('Are you sure you want to cancel? Any unsaved changes will be lost.')) {
            dialog.close();
        }
    });
    
    // Close dialog when clicking outside (backdrop)
    dialog.addEventListener('click', (e) => {
        const dialogDimensions = dialog.getBoundingClientRect();
        if (
            e.clientX < dialogDimensions.left ||
            e.clientX > dialogDimensions.right ||
            e.clientY < dialogDimensions.top ||
            e.clientY > dialogDimensions.bottom
        ) {
            if (confirm('Are you sure you want to close? Any unsaved changes will be lost.')) {
                dialog.close();
            }
        }
    });
    
    // Preview uploaded image
    document.getElementById('profile_path').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('profile-preview').src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Handle form submission
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Profile updated successfully!');
        dialog.close();
    });
</script>

<!-- Add CSS for dialog backdrop -->
<style>
    dialog::backdrop {
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(2px);
    }
    
    dialog {
        max-height: 90vh;
        overflow-y: auto;
    }
    
    /* Prevent scrolling of background when dialog is open */
    body.overflow-hidden {
        overflow: hidden;
    }
</style>
