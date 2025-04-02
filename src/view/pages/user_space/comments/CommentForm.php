<?php
require_once __DIR__ . '/../../../../controller/CommentsController.php';
// var_dump($_GET);
$comment_id = null;
$reply_id = null;
$comment_content = "";

if (isset($_GET['edit'])) {
    $comment_id = $_GET['edit'];

    $comment = CommentController::getCommentById($comment_id);
    if ($comment) {
        $comment_content = $comment['comment'];
    }
}

if (isset($_GET['match'])) {
    $user_id = $_SESSION['admin_id'];
    // $user_id = $_GET['user'];
    $match_id = $_GET['match'];
    if (isset($_GET['reply'])) {
        $reply_id = $_GET['reply'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // var_dump($_POST);
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        CommentController::update();
    } else {
        CommentController::store();
    }
}

?>

<div class="flex w-full h-full justify-center items-center">
    <!-- Comment Form -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8 w-[70%]">
        <div class="p-6">
            <h2 class="text-xl font-semibold text-green-700 mb-4">Share Your Thoughts</h2>

            <?php if (true): ?>
                <form method="POST" action="comments/CommentForm.php" class="space-y-4">

                    <input type="hidden" name="id" value="<?php echo $comment_id; ?>">
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                    <input type="hidden" name="match_id" value="<?php echo $match_id; ?>">
                    <?php if (isset($reply_id)): ?>
                        <input type="hidden" name="comment_reply_id" value="<?php echo $reply_id; ?>">
                    <?php endif; ?>
                    <input type="hidden" name="likes" value="<?php echo $likes; ?>">
                    <div>
                        <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Your Comment</label>
                        <textarea id="comment" name="comment" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            placeholder="What's on your mind about football?"><?php echo $comment_content; ?></textarea>
                    </div>

                    <div class="flex justify-end space-x-4">
                        <a href="Accueil?Target=comments" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-6 rounded-lg transition duration-300 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancel
                        </a>
                        <button type="submit"
                            class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-medium py-2 px-6 rounded-lg transition duration-300 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            Post Comment
                        </button>
                    </div>
                </form>
            <?php else: ?>
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                You need to <a href="../Login.php" class="font-medium underline text-yellow-700 hover:text-yellow-600">log in</a> to post a comment.
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>