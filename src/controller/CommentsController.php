<?php
require_once __DIR__ . '/../helper/UploadFileHelper.php';
require_once __DIR__ . '/../model/Comment.php';
require_once __DIR__ . '/../model/Admin.php';
require_once __DIR__ . '/Controller.php';

class CommentController extends Controller
{
    private static $uploadDirectory = __DIR__ . '/../../public/uploads/admin_profiles/';
    private static $uploadSubDirectory = 'admin_profiles';

    public static function index(): array
    {
        try {
            $comments = Comment::getAll();

            if ($comments) {

                $mappedComments = [];
                foreach ($comments as $comment) {

                    $user = Admin::getById($comment['user_id']);

                    if (!$user) {
                        $error = "User not found";
                        include __DIR__ . '/../view/Error.php';
                        return [];
                    }

                    $mappedComments[] = [
                        'id' => $comment[Comment::$id],
                        'user_id' => $comment[Comment::$user_id],
                        'match_id' => $comment[Comment::$match_id],
                        'comment_reply_id' => $comment[Comment::$comment_reply_id],
                        'comment' => $comment[Comment::$comment],
                        'date' => $comment[Comment::$date],
                        'username' => $user[Admin::$firstName] . ' ' . $user[Admin::$lastName],
                        'profile_logo' => 'http://efoot/logo?file=' . $user[Admin::$profilePath] . '&dir=' . self::$uploadSubDirectory
                    ];
                }

                return $mappedComments;
            } else {
                return [];
            }
        } catch (Exception $e) {
            $error = "Error fetching Comments: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
            return [];
        }
    }

    public static function getCommentById($id): array
    {
        try {
            $comment = Comment::getById($id);

            return $comment;
        } catch (Exception $e) {
            $error = "Error fetching Comment: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
            return [];
        }
    }

    public static function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $error = "Invalid request method";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        $id = isset($_POST['id']) ? trim(intval($_POST['id'])) : null;
        $user_id = isset($_POST['user_id']) ? trim(intval($_POST['user_id'])) : null;
        $match_id = isset($_POST['match_id']) ? trim(intval($_POST['match_id'])) : null;
        $comment_reply_id = isset($_POST['comment_reply_id']) ? trim(intval($_POST['comment_reply_id'])) : null;
        $comment = isset($_POST['comment']) ? trim($_POST['comment']) : null;
        $date = isset($_POST['date']) ? trim($_POST['date']) : null;

        $data = [
            'id' => $id,
            'user_id' => $user_id,
            'match_id' => $match_id,
            'comment_reply_id' => $comment_reply_id,
            'comment' => $comment,
            'date' => $date
        ];

        $rules = [
            Comment::$user_id => 'numeric',
            Comment::$match_id => 'numeric',
            Comment::$comment_reply_id => 'numeric|nullable',
            Comment::$comment => 'required|max:1000',
            Comment::$date => 'date'
        ];

        $validate_result = true; //self::validate($data, $rules);
        if ($validate_result !== true) {
            $error = $validate_result;
            include __DIR__ . '/../view/Error.php';
            return;
        }


        $date = date('Y-m-d H:i:s');
        $data[Comment::$date] = $date;

        try {
            Comment::create($data);
            header("Location: ../Accueil.php?Target=comments&&success=1");
            exit();
        } catch (Exception $e) {
            if (isset($image_path)) {
                deleteImage(self::$uploadDirectory . $image_path);
            }
            $error = "Failed to create Comment: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
        }
    }

    public static function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $error = "Invalid request method";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        $id = isset($_POST['id']) ? trim(intval($_POST['id'])) : null;
        $user_id = isset($_POST['user_id']) ? trim(intval($_POST['user_id'])) : null;
        $match_id = isset($_POST['match_id']) ? trim(intval($_POST['match_id'])) : null;
        $comment_reply_id = isset($_POST['comment_reply_id']) ? trim(intval($_POST['comment_reply_id'])) : null;
        $comment = isset($_POST['comment']) ? trim($_POST['comment']) : null;
        $date = isset($_POST['date']) ? trim($_POST['date']) : null;

        if (!$id) {
            $error = "Id is required";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        $comment_data = Comment::getById($id);
        if (!$comment_data) {
            $error = "Comment not found";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        $data = [
            'id' => $id,
            'user_id' => $user_id,
            'match_id' => $match_id,
            'comment_reply_id' => $comment_reply_id,
            'comment' => $comment,
            'date' => $date
        ];

        $rules = [
            Comment::$user_id => 'required|numeric',
            Comment::$match_id => 'required|numeric',
            Comment::$comment_reply_id => 'numeric|nullable',
            Comment::$comment => 'required|max:1000',
            Comment::$date => 'required|date'
        ];

        $validate_result = true;//self::validate($data, $rules);

        if ($validate_result !== true) {
            $error = $validate_result;
            include __DIR__ . '/../view/Error.php';
            return;
        }

        try {
            $result = Comment::update($id, $data);

            if ($result) {

                header("Location: ../Accueil.php?Target=comments&&updated=1");
                exit();
            } else {
                $error = "Comment not found or already updated";
                include __DIR__ . '/../view/Error.php';
            }
        } catch (Exception $e) {
            $error = "Error updating Comment: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
        }
    }

    public static function deleteComment($id): void
    {
        if (!$id) {
            $error = "Comment ID is required";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        try {
            $comment = Comment::getById($id);
            if (!$comment) {
                $error = "Comment not found";
                include __DIR__ . '/../view/Error.php';
                return;
            }

            Comment::delete($id);

            header("Location: ../Accueil.php?Target=comments&&deleted=1");
            exit();
        } catch (Exception $e) {
            $error = "Error deleting Comment: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
        }
    }
}
