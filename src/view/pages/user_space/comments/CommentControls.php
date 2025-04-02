<?php
require_once  __DIR__ . '/../../../../controller/CommentsController.php';
if (isset($_POST['id'])) {
    $comment_id = $_POST['id'];
    if (isset($_POST['action']) && $_POST['action'] == 'delete') {
        CommentController::deleteComment($comment_id);
    }
}
?>

<div class="flex-1">
    <div class="flex items-center justify-between">
        <h4 class="text-lg font-medium text-gray-900"><?php echo $comment['username'] ?></h4>
        <time class="text-xs text-gray-500"><?php echo $comment['date'] ?></time>
    </div>
    <p class="mt-2 text-gray-700"><?php echo $comment['comment'] ?></p>
    <div class="mt-4 flex items-center space-x-4">
        <button class="flex items-center text-gray-500 hover:text-green-600 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
            </svg>
            <span>Like</span>
        </button>
        <a
            href="Accueil?Target=comment_form&&user=1&&match=1&&reply=<?php echo $comment['id']; ?>"
            class="flex items-center text-gray-500 hover:text-green-600 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
            <span>Reply</span>
        </a>
        <button class="flex items-center text-gray-500 hover:text-red-600 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <span>Report</span>
        </button>

        <?php if ($comment['user_id'] == $_SESSION['admin_id']): ?>
            <a href="Accueil?Target=comment_form&&match=1&&edit=<?php echo $comment['id']; ?>"
                class="flex items-center text-gray-500 hover:text-blue-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <span>Edit</span>
            </a>
            <form method="POST" action="comments/CommentControls.php">
                <input type="hidden" name="id" value="<?php echo $comment['id']; ?>">
                <input type="hidden" name="action" value="delete">
                <button type="submit"
                    class="flex items-center text-gray-500 hover:text-red-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    <span>Delete</span>
                    </>
            </form>
        <?php endif; ?>
    </div>
</div>