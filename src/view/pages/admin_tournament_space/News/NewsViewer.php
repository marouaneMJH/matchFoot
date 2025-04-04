<?php
require_once __DIR__ . '/../../../../controller/NewsController.php';
require_once __DIR__ . '/../../../../model/News.php';

// Get news ID from URL parameter
$newsId = isset($_GET['id']) ? $_GET['id'] : null;

// If no ID provided, redirect back
if (!$newsId) {
    header('Location: ../TournamentInfos.php');
    exit;
}

// Get the news item details
$newsItem = NewsController::getNewsById($newsId);

// If news not found, show error
if (empty($newsItem)) {
    $error = "News article not found";
    include __DIR__ . '/../../../Error.php';
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($newsItem[News::$title]); ?> | MatchFoot</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../../styles/output.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Back button -->
        <div class="mb-6">
            <a href="javascript:history.back()" class="inline-flex items-center text-green-700 hover:text-green-900 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to News List
            </a>
        </div>

        <!-- News Article - Enhanced styling -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <!-- News Header with improved image handling -->
            <div class="relative">
                <?php if (isset($newsItem['image']) && $newsItem['image']): ?>
                    <div class="h-80 w-full overflow-hidden">
                        <img class="w-full h-full object-cover transform hover:scale-105 transition-transform duration-500" 
                             src="<?php echo $newsItem['image']; ?>" 
                             alt="<?php echo htmlspecialchars($newsItem[News::$title]); ?>">
                    </div>
                <?php else: ?>
                    <div class="h-80 w-full bg-gradient-to-r from-green-500 to-green-700 flex items-center justify-center">
                        <svg class="w-32 h-32 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                    </div>
                <?php endif; ?>
                
                <!-- Category Badge with improved styling -->
                <div class="absolute top-4 right-4">
                    <span class="px-4 py-2 rounded-full text-sm font-bold bg-purple-100 text-purple-800 shadow-md">
                        <?php echo htmlspecialchars($newsItem[News::$category]); ?>
                    </span>
                </div>
            </div>
            
            <div class="p-8">
                <!-- Title and Meta -->
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-green-900 mb-2"><?php echo htmlspecialchars($newsItem[News::$title]); ?></h1>
                    
                    <div class="flex items-center text-sm text-gray-500 mt-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <?php echo date('F j, Y', strtotime($newsItem[News::$date])); ?>
                        </span>
                        
                        <span class="mx-3">•</span>
                        
                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <?php echo htmlspecialchars($newsItem[News::$status]); ?>
                        </span>
                        
                        <?php if (isset($newsItem['club_name']) && $newsItem['club_name']): ?>
                            <span class="mx-3">•</span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <?php echo htmlspecialchars($newsItem['club_name']); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Content -->
                <div class="prose max-w-none text-gray-700 leading-relaxed">
                    <?php echo nl2br(htmlspecialchars($newsItem[News::$content])); ?>
                </div>
                
                <!-- Actions -->
                <div class="mt-10 pt-6 border-t border-gray-200 flex justify-between items-center">
                    <div class="flex space-x-4">
                        <button class="flex items-center text-gray-500 hover:text-green-600 transition">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            Like
                        </button>
                        <button class="flex items-center text-gray-500 hover:text-green-600 transition">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                            </svg>
                            Share
                        </button>
                        <a href="#comments" class="flex items-center text-gray-500 hover:text-green-600 transition">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                            </svg>
                            Comments
                        </a>
                    </div>
                    
                    <?php if (isset($_SESSION['admin_id'])): ?>
                    <div class="flex space-x-3">
                        <a href="../TournamentInfos.php?showModal=edit&&id=<?php echo $newsItem[News::$id]; ?>" class="text-blue-600 hover:text-blue-900 transition-colors flex items-center">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit
                        </a>
                        <a href="../news/DeleteNews.php?id=<?php echo $newsItem[News::$id]; ?>" class="text-red-600 hover:text-red-900 transition-colors flex items-center" onclick="return confirm('Are you sure you want to delete this news article?');">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Comments Section -->
        <div id="comments" class="mt-8">
            <h2 class="text-xl font-semibold text-green-800 mb-4">Comments</h2>
            
            <!-- Comment Form -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
                <div class="p-6">
                    <form action="../../user_space/comments/submit_comment.php" method="POST" class="space-y-4">
                        <input type="hidden" name="news_id" value="<?php echo $newsItem[News::$id]; ?>">
                        <div>
                            <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Your Comment</label>
                            <textarea id="comment" name="comment" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Share your thoughts on this news..."></textarea>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-medium py-2 px-6 rounded-lg transition duration-300 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                                Post Comment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Comments List -->
            <div class="space-y-4">
                <?php
                // Here you would fetch and display comments related to this news article
                // This is a placeholder for demonstration
                ?>
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-start space-x-4">
                            <img class="h-10 w-10 rounded-full object-cover border-2 border-green-200" 
                                src="http://efoot/logo?file=user-placeholder.png&dir=image_placeholder" alt="User avatar">
                            
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <h4 class="text-sm font-medium text-gray-900">Mohammed Alami</h4>
                                    <time class="text-xs text-gray-500">2 hours ago</time>
                                </div>
                                <p class="mt-1 text-sm text-gray-700">Great article! I'm looking forward to the next match.</p>
                                <div class="mt-2 flex items-center space-x-4">
                                    <button class="flex items-center text-xs text-gray-500 hover:text-green-600 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                        </svg>
                                        <span>Like</span>
                                    </button>
                                    <button class="flex items-center text-xs text-gray-500 hover:text-green-600 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                        </svg>
                                        <span>Reply</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>