<?php
require_once __DIR__ . '/../helper/UploadFileHelper.php';
require_once __DIR__ . '/../model/News.php';
require_once __DIR__ . '/Controller.php';

class NewsController extends Controller
{
    private static $uploadDirectory = __DIR__ . '/../../public/uploads/news_image/';
    private static $uploadSubDirectory = 'news_image';

    public static function index(): array
    {
        try {
            $news = News::getAll();

            $modifiedNews = [];
            if ($news) {
                foreach ($news as $news) {
                    if ($news[News::$image_path])
                        $news['image'] = 'http://efoot/logo?file=' . $news[News::$image_path] . '&dir=' . self::$uploadSubDirectory;

                    $modifiedNews[] = $news;
                }

                rsort($modifiedNews);

                return $modifiedNews;
            } else {
                return [];
            }
        } catch (Exception $e) {
            $error = "Error fetching newss: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
            return [];
        }
    }

    public static function getNewsById($id): array
    {
        $news = News::getById($id);
        if (!$news) {
            $error = "News not found";
            include __DIR__ . '/../view/Error.php';
            return [];
        }

        $news['image'] = 'http://efoot/logo?file=' . $news[News::$image_path] . '&dir=' . self::$uploadSubDirectory;


        return $news; // Display news details
    }

    public static function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $error = "Invalid request method";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        $admin_id = isset($_POST['admin_id']) ? trim(intval($_POST['admin_id'])) : 4;
        $title = isset($_POST['title']) ? trim(string: $_POST['title']) : null;
        $content = isset($_POST['content']) ? trim($_POST['content']) : null;
        $category = isset($_POST['category']) ? trim($_POST['category']) : null;
        $status = isset($_POST['status']) ? trim($_POST['status']) : null;
        $date = isset($_POST['date']) ? trim(intval($_POST['date'])) : null;
        $image_path = null;



        $data = [
            News::$admin_id => $admin_id,
            News::$title => $title,
            News::$content => $content,
            News::$category => $category,
            News::$status => $status,
            News::$date => $date
        ];
        var_dump($data);

        $rules = [
            News::$title => 'required|max:255',
            News::$content => 'required',
            News::$category => 'required',
            News::$status => 'required'
        ];
        $validate_result = self::validate($data, $rules);
        if ($validate_result !== true) {
            $error = $validate_result;
            include __DIR__ . '/../view/Error.php';
            return;
        }

        // Handle file upload
        if (isset($_FILES["image"]) && $_FILES["image"]["size"] > 0) {
            $image = $_FILES["image"];
            $image_path = uploadImage($image, self::$uploadDirectory);
        }

        $date = date('Y-m-d H:i:s');
        $data[News::$image_path] = $image_path ?? null;
        $data[News::$date] = $date;

        try {
            News::create($data);
            header("Location: TournamentInfos.php?success=1");
            exit();
        } catch (Exception $e) {
            if (isset($image_path)) {
                deleteImage(self::$uploadDirectory . $image_path);
            }
            $error = "Failed to create news: " . $e->getMessage();
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
        $admin_id = isset($_POST['admin_id']) ? trim(intval($_POST['admin_id'])) : 4;
        $title = isset($_POST['title']) ? trim(string: $_POST['title']) : null;
        $content = isset($_POST['content']) ? trim($_POST['content']) : null;
        $category = isset($_POST['category']) ? trim($_POST['category']) : null;
        $status = isset($_POST['status']) ? trim($_POST['status']) : null;
        $date = isset($_POST['date']) ? trim(intval($_POST['date'])) : null;
        $image_path = null;
        $old_image_path = null;

        if (!$id) {
            $error = "Id is required";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        $news = News::getById($id);
        if (!$news) {
            $error = "News not found";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        $data = [
            News::$admin_id => $news[News::$admin_id],
            News::$title => $title,
            News::$content => $content,
            News::$category => $category,
            News::$status => $status,
            News::$date => $news[News::$date]
        ];

        $rules = [
            News::$title => 'required|max:255',
            News::$content => 'required',
            News::$category => 'required',
            News::$status => 'required'
        ];

        $validate_result = self::validate($data, $rules);

        if ($validate_result !== true) {
            $error = $validate_result;
            include __DIR__ . '/../view/Error.php';
            return;
        }

        $image_path = $news[News::$image_path];

        // Handle file upload
        if (isset($_FILES["image"]) && $_FILES["image"]["size"] > 0) {
            $image = $_FILES["image"];
            $old_image_path = $image_path;
            $image_path = uploadImage($image, self::$uploadDirectory);
        }

        $data[News::$image_path] = $image_path;
        $data[News::$date] = $news[News::$date];

        try {
            $result = News::update($id, $data);

            if ($result) {
                // Delete old image if new image is uploaded
                if ($old_image_path) {
                    deleteImage(self::$uploadDirectory . $old_image_path);
                }

                header("Location: TournamentInfos.php?updated=1");
                exit();
            } else {
                // Delete new image if update failed
                if ($old_image_path) {
                    deleteImage(self::$uploadDirectory . $image_path);
                }
                $error = "News not found or already updated";
                include __DIR__ . '/../view/Error.php';
            }
        } catch (Exception $e) {
            $error = "Error updating news: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
        }
    }

    public static function deleteNews($id): void
    {
        if (!$id) {
            $error = "News ID is required";
            include __DIR__ . '/../view/Error.php';
            return;
        }

        try {
            $news = News::getById($id);
            if (!$news) {
                $error = "News not found";
                include __DIR__ . '/../view/Error.php';
                return;
            }
            $image_path = $news[News::$image_path];
            News::delete($id);

            if ($image_path) {
                deleteImage(self::$uploadDirectory . $image_path);
            }
            header("Location: ../TournamentInfos.php?deleted=1");
            exit();
        } catch (Exception $e) {
            $error = "Error deleting news: " . $e->getMessage();
            include __DIR__ . '/../view/Error.php';
        }
    }
}
