<?php
require_once __DIR__ . '/Model.php';

class News extends Model
{
    use DbConnection;

    protected static $table = 'news';

    private array $preparedNotifications = [];

    // Static variables with normal names
    public static $id = "id";
    public static $admin_id = "admin_id";
    public static $title = "title";
    public static $content = "content";
    public static $category = "category";
    public static $status = "status";
    public static $image_path = "image_path";
    public static $date = "date";
    public static $team_id = "team_id";
    
    // Instance properties with field prefix
    public $fieldId;
    public $fieldAdminId;
    public $fieldTitle;
    public $fieldContent;
    public $fieldCategory;
    public $fieldStatus;
    public $fieldImagePath;
    public $fieldDate;
    public $fieldTeamId;

    public function __construct($id = null, $admin_id = null, $title = null, $content = null, $category = null, $status = null, $date = null, $team_id = null) {
        $this->fieldId = $id;
        $this->fieldAdminId = $admin_id;
        $this->fieldTitle = $title;
        $this->fieldContent = $content;
        $this->fieldCategory = $category;
        $this->fieldStatus = $status;
        $this->fieldDate = $date;
        $this->fieldTeamId = $team_id;
    }

    private function getTimeAgo(DateTime $datetime): string {
        $now = new DateTime();
        $diff = $now->diff($datetime);

        if ($diff->y > 0) return $diff->y . ' year' . ($diff->y > 1 ? 's' : '') . ' ago';
        if ($diff->m > 0) return $diff->m . ' month' . ($diff->m > 1 ? 's' : '') . ' ago';
        if ($diff->d > 0) return $diff->d . ' day' . ($diff->d > 1 ? 's' : '') . ' ago';
        if ($diff->h > 0) return $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
        if ($diff->i > 0) return $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ago';

        return 'just now';
    }

    private function getCategoryColor(string $category): string {
        $categoryColors = [
            'match' => 'green',
            'transfer' => 'blue',
            'injury' => 'red',
            'event' => 'yellow',
            'announcement' => 'indigo'
        ];
        return $categoryColors[strtolower($category)] ?? 'gray';
    }

    public function getNewsByUserId(int $userId): void {
        try {
            $pdo = self::connect();

            $query = "
                SELECT n.id, n.title, n.date, n.category, t.name AS team_name
                FROM news n
                INNER JOIN subscription s ON n.club_id = s.team_id
                INNER JOIN club t ON s.team_id = t.id
                WHERE s.user_id = :userId
                ORDER BY n.date DESC
                LIMIT 10
            ";

            $stmt = $pdo->prepare($query);
            // $userId = 4;
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            error_log($stmt->queryString); // Log the query for debugging
            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $result) {
                $datetime = new DateTime($result['date']);
                $timeAgo = $this->getTimeAgo($datetime);
                $type = $this->getCategoryColor($result['category']);

                $this->addNotification(
                    $result['title'],
                    "{$timeAgo} - {$result['team_name']}",
                    $type,
                    $result['id']
                );
            }
        } catch (PDOException $e) {
            // You could log this to a file or system log
            // error_log("News fetch error: " . $e->getMessage());
        }
    }

    public function addNotification(string $message, string $time, string $type = 'blue', int $newsId = 0): void {
        $this->preparedNotifications[] = [
            'message' => $message,
            'time' => $time,
            'type' => $type,
            'id' => $newsId
        ];
    }

    public function getPreparedNotifications(): array {
        return $this->preparedNotifications;
    }
}