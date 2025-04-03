<?php

    require_once './components/Sidebar.php';
    require_once './components/HeaderNavBar.php';

    $headerNavbar = new HeaderNavBar('../../');
    $sidebar = new Sidebar('../../');


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
        <!-- Sidebar (hardcoded) -->
        <!-- <div class="w-72 bg-green-800 text-white fixed h-full">
            <div class="p-4">
                <div class="flex items-center space-x-2 mb-6">
                    <div class="bg-white w-8 h-8 rounded-lg flex items-center justify-center">
                        <span class="text-green-800 font-bold">SF</span>
                    </div>
                    <h1 class="text-xl font-bold">SoftFootBall</h1>
                </div>
                
                <nav>
                    <ul class="space-y-2">
                        <li>
                            <a href="#" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-green-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-green-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                <span>Tournaments</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-green-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>Teams</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center space-x-2 p-2 rounded-lg hover:bg-green-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>Players</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center space-x-2 p-2 bg-green-700 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Profile</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div> -->

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

                    <!-- Profile Content -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Profile Card -->
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-green-100 lg:col-span-1">
                            <div class="flex flex-col items-center">
                                <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-green-100 mb-4">
                                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Profile Picture" class="w-full h-full object-cover">
                                </div>
                                
                                <h2 class="text-xl font-bold text-green-900">John Doe</h2>
                                <p class="text-green-600">@johndoe</p>
                                
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
                                        <span class="text-sm font-medium text-green-900">Jan 15, 2023</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-500">Last login</span>
                                        <span class="text-sm font-medium text-green-900">Today, 10:30 AM</span>
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
                                        <div class="text-green-900 font-medium">johndoe</div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Display Name</label>
                                        <div class="text-green-900 font-medium">John Doe</div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Email Address</label>
                                        <div class="text-green-900 font-medium">john.doe@example.com</div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 mb-1">Birth Date</label>
                                        <div class="text-green-900 font-medium">April 12, 1985</div>
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
                                        <button class="bg-green-100 text-green-700 py-2 px-4 rounded-lg hover:bg-green-200 transition">
                                            Change Password
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-8 pt-6 border-t border-green-100">
                                <h3 class="text-lg font-semibold text-green-900 mb-4">Recent Activity</h3>
                                
                                <div class="space-y-4">
                                    <div class="flex items-start space-x-3">
                                        <div class="bg-green-100 p-2 rounded-full">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-green-900">Logged in from new device</p>
                                            <p class="text-xs text-gray-500">Today, 10:30 AM</p>
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
                                            <p class="text-xs text-gray-500">Jan 20, 2023</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- edit dialog  -->
                <?php include 'EditProfile.php'; ?>
            </div>
        </div>
    </div>
</body>
</html>