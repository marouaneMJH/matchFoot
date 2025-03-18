<?php


// Get the route from the URL
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($requestUri) {
   
    case '/logo' :
        if (!isset($_GET['file']) || !isset($_GET['dir'])) {
            return; //jsonResponse(['message' => 'File name required'], 400);
        }
        $fileName = basename($_GET['file']);
        $dir = basename($_GET['dir']);
        $filePath = __DIR__ . "/../../public/uploads/" . $dir . "/" . $fileName;

        $defaultDir = 'image_placeholder';
        $defaultFileName = 'image-placeholder.png';

        if (!file_exists($filePath)) {
            $filePath = __DIR__ . "/../../public/uploads/" . $defaultDir . "/" . $defaultFileName;
        }

        // Determine the correct Content-Type
        $mimeType = mime_content_type($filePath);
        header("Content-Type: " . $mimeType);
        readfile($filePath);
        
        exit;
    
    default:
        $error = "Page not found";
        include __DIR__ . '/error.php';
}
