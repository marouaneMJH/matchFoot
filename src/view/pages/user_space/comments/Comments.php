<?php

require_once  __DIR__ . '/../../../../controller/CommentsController.php';
require_once  __DIR__ . '/../../../../model/Comment.php';
// session_start();

?>


<div class="bg-gray-50 w-full relative">

    <div class="container mx-auto px-4 py-8 max-w-5xl">
        <div class="flex justify-between items-center">
            <a href="Accueil?Target=accueil" class="absolute top-4 right-4 flex items-center justify-center p-2 rounded-full bg-white shadow-md text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-all duration-200 transform hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span class="sr-only">Close</span>
            </a>
            <div class="mb-4 flex-1 flex-col justify-start items-start">
                <h1 class="text-2xl font-bold text-green-800">Comments</h1>
                <p class="text-gray-600 mt-2">Join the conversation about matches, teams, players and more</p>
            </div>
            <a href="Accueil?Target=comment_form&&match=1" class="flex items-center justify-center px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                New Comment
            </a>
        </div>


        <!-- 
        <div class="flex flex-wrap justify-between items-center">


            <div class="relative">
                <select class="bg-white border border-gray-300 text-gray-700 py-2 pl-4 pr-10 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <option>Most Recent</option>
                    <option>Most Liked</option>
                    <option>Most Discussed</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h- w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                    </svg>
                </div>
            </div>
        </div> -->

        <!-- Comments List -->
        <div class="space-y-6  overflow-auto h-[60vh] p-3">
            <?php
            $comments = CommentController::index();
            // var_dump($comments);
            if (empty($comments)): ?>
                <div class="bg-white rounded-xl shadow-md p-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">No comments yet</h3>
                    <p class="mt-1 text-gray-500">Be the first to start a conversation!</p>
                </div>
                <?php else:

                foreach ($comments as $comment):
                    if (isset($comment["comment_reply_id"])): ?>
                        <!-- Reply 1 -->
                        <div class="mt-2 space-y-4">
                            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                                <div class="p-6">
                                    <div class="flex justify-between items-center mb-2">
                                        <div class="flex items-center">
                                            <span class="text-xs text-gray-500 mr-2">Replying to</span>
                                            <span class="text-xs font-medium text-green-700"><?php echo $comment['username'] ?></span>
                                        </div>
                                    </div>
                                    <div class="flex items-start space-x-4">
                                        <img class="h-12 w-12 rounded-full object-cover border-2 border-green-200"
                                            src="<?php echo isset($comment['profile_logo']) ? $comment['profile_logo'] : 'http://efoot/logo?file=user-placeholder.png&dir=image_placeholder' ?>" alt="User avatar">
                                        <?php include 'CommentControls.php' ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php else: ?>
                        <!-- Comment 1 -->
                        <div class="mt-2 space-y-4">
                            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                                <div class="p-6">

                                    <div class="flex items-start space-x-4">
                                        <img class="h-12 w-12 rounded-full object-cover border-2 border-green-200"
                                            src="http://efoot/logo?file=user-placeholder.png&dir=image_placeholder" alt="User avatar">

                                            <?php include 'CommentControls.php' ?>
                                    </div>
                                </div>
                            </div>
                        </div>



            <?php
                    endif;
                endforeach;
            endif; ?>

        </div>
        <!-- Pagination -->
        <!-- <div class="flex justify-center mt-4">
            <nav class="inline-flex rounded-md shadow">
                <a href="#" class="py-2 px-4 bg-white text-green-600 font-medium rounded-l-md border border-gray-200 hover:bg-green-50">Previous</a>
                <a href="#" class="py-2 px-4 bg-green-600 text-white font-medium border border-green-600">1</a>
                <a href="#" class="py-2 px-4 bg-white text-green-600 font-medium border border-gray-200 hover:bg-green-50">2</a>
                <a href="#" class="py-2 px-4 bg-white text-green-600 font-medium border border-gray-200 hover:bg-green-50">3</a>
                <a href="#" class="py-2 px-4 bg-white text-green-600 font-medium rounded-r-md border border-gray-200 hover:bg-green-50">Next</a>
            </nav>
        </div>
    </div> -->

    </div>