<?php

class Image
{

    public static  string $rootPath  = "http://efoot/logo";
    public static  string $fileQuery = "file=";
    public static  string $dirQuery  = "&dir=";


    /// src="http://efoot/logo?file=img-placeholder.png&dir=image_placeholder"
    public static function getImage(
            string $fileName = 'img-placeholder.png',
            string $uploadDir = 'image_placeholder'
    ) :string
    {
        // Path to the default image

        // If filename is empty or file doesn't exist, use default
        if (empty(trim($fileName)) || !file_exists(__DIR__ . '/../../public/uploads/' .$uploadDir . $fileName)) {
                return self::$rootPath .'?'. self::$fileQuery . $fileName . self::$dirQuery . $uploadDir;
        }

        return self::$rootPath .'?' .self::$fileQuery . $fileName . self::$dirQuery . $uploadDir;
    }

    public static function uploadImage($image, $uploadDir): string
    {
        if (isset($image)) {
            if ($image["error"] !== UPLOAD_ERR_OK) {
                $error = "Error uploading file: " . $image["error"];
                include __DIR__ . '/../view/Error.php';
            }

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileName = basename($image['name']);
            $fileTmpPath = $image['tmp_name'];
            $fileSize = $image['size'];
            $fileType = $image['type'];

            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];

            if (!in_array($fileType, $allowedTypes)) {
                $error = "Invalid file type. Only JPEG, JPG, and PNG files are allowed.";
                include __DIR__ . '/../view/Error.php';
            }

            $newFileName = time() . "_" . uniqid() . "_" . $fileName;
            $destination = $uploadDir . $newFileName;

            if (!move_uploaded_file($fileTmpPath, $destination)) {
                $error = "Error uploading file.";
                include __DIR__ . '/../view/Error.php';
            }

            return $newFileName;
        }

        $error = "No file selected";
        include __DIR__ . '/../view/Error.php';
        return "";
    }

    public static function deleteImage($imagePath): bool
    {
        if (file_exists($imagePath)) {
            if (unlink($imagePath)) {
                return true;
            } else {
                $error = "Error deleting image";
                include __DIR__ . '/../view/Error.php';
                return false;
            }
        }

        $error = "Image not found";
        include __DIR__ . '/../view/Error.php';
        return false;
    }
}
?>