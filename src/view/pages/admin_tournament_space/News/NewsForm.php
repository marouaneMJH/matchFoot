<?php

$title = "";
$content = "";
$category = "";
$status = "";
$newsId = "";
$club_id = null;
$showModal = "";

if (isset($_GET['id'])) {
    $newsItem = NewsController::getNewsById($_GET['id']);

    $title = $newsItem[News::$title];
    $content = $newsItem[News::$content];
    $category = $newsItem[News::$category];
    $status = $newsItem[News::$status];
    $newsId = $newsItem[News::$id];
    $club_id = $newsItem[News::$club_id];
}

if (isset($_GET['showModal'])) {
    $showModal = $_GET['showModal'];
}

$clubs = ClubController::index();
// var_dump($clubs);

?>

<div id="newsModal" class="fixed inset-0 bg-green-50 bg-opacity-50 items-center justify-center 
    <?php if ($showModal == "edit")
        echo 'flex';
    else
        echo 'hidden'; ?>">
    <div class="newsModal-content bg-white rounded-xl shadow-xl w-full max-w-2xl mx-4 p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-green-900">Create News Article</h2>
                <p class="text-green-600 mt-1">Share updates about the tournament</p>
            </div>
            <button onclick="closeNewsModal()" class="text-green-600 hover:text-green-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form action="TournamentInfos.php" method="post" id="NewsForm" enctype="multipart/form-data" class="space-y-6">

            <input type="text" name="id" value="<?php echo $newsId; ?>" hidden />
            <div>
                <label class="block text-sm font-medium text-green-700 mb-1">Title</label>
                <input type="text" name="title" value="<?php echo $title ?>"
                    class="w-full px-4 py-2.5 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                    placeholder="Enter news title">
            </div>

            <div>
                <label class="block text-sm font-medium text-green-700 mb-1">Club</label>

                <select name="club_id"
                    class="w-full px-4 py-2.5 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">

                    <?php
                    if ($clubs) {
                        foreach ($clubs as $club) {
                            echo '<option value="' . $club[Club::$id] . '"';
                            if ($club_id == $club[Club::$id])
                                echo 'selected';
                            echo '>' . $club[Club::$name] . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-green-700 mb-1">Category</label>
                    <select name="category"
                        class="w-full px-4 py-2.5 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="schedule" <?php if ($category == 'schedule')
                                                        echo 'selected'; ?>>Schedule</option>
                        <option value="results" <?php if ($category == 'results')
                                                    echo 'selected'; ?>>Results</option>
                        <option value="announcements" <?php if ($category == 'announcements')
                                                            echo 'selected'; ?>>
                            Announcements</option>
                        <option value="highlights" <?php if ($category == 'highlights')
                                                        echo 'selected'; ?>>Highlights
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-green-700 mb-1">Status</label>
                    <select name="status"
                        class="w-full px-4 py-2.5 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="draft" <?php if ($status == 'draft')
                                                    echo 'selected'; ?>>Draft</option>
                        <option value="published" <?php if ($status == 'published')
                                                        echo 'selected'; ?>>Published</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-green-700 mb-1">Featured Image</label>
                <input type="file" name="image"
                    class="w-full px-4 py-2.5 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
            </div>

            <div>
                <label class="block text-sm font-medium text-green-700 mb-1">Content</label>
                <textarea rows="6" name="content"
                    class="w-full px-4 py-2.5 border border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                    placeholder="Write your news content here..."><?php echo $content ?></textarea>
            </div>

            <div class="flex justify-end space-x-3 pt-6 border-t border-green-100">
                <button type="button" onclick="closeNewsModal()"
                    class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                    Cancel
                </button>
                <button type="submit" class="green-gradient px-6 py-2.5 text-white rounded-lg hover:opacity-90">
                    Publish News
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById("newsModal");

    function openNewsModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeNewsModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Handle form validation
    const newsForm = document.getElementById("NewsForm");
    newsForm.addEventListener("submit", (e) => {
        const title = newsForm.querySelector("[name='title']").value;
        const content = newsForm.querySelector("[name='content']").value;

        if (!title.trim() || !content.trim()) {
            e.preventDefault();
            alert("Please fill in all required fields");
        }
    });
</script>