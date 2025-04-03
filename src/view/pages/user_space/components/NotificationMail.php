<?php

class NotificationMailButton {
    private int $notificationCount = 0;
    private array $notifications = [];
    private string $viewAllLink = 'News.php';
    private int $userId;

    public function __construct(int $userId) {
        $this->userId = $userId;
        $this->loadNotifications();
    }

    private function loadNotifications(): void {
        // Clear existing notifications
        $this->notifications = [];
        
        try {
            $db = new PDO('mysql:host=localhost;dbname=efoot', 'root', '');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Get news for teams the user is subscribed to
            $query = "
                SELECT n.id, n.title, n.date, n.category, t.name AS team_name
                FROM news n
                JOIN subscription s ON n.team_id = s.team_id
                JOIN team t ON s.team_id = t.id
                WHERE s.user_id = :userId
                ORDER BY n.date DESC
                LIMIT 10
            ";
            
            $stmt = $db->prepare($query);
            $stmt->bindParam(':userId', $this->userId, PDO::PARAM_INT);
            $stmt->execute();
            
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($results as $result) {
                $datetime = new DateTime($result['date']);
                $timeAgo = $this->getTimeAgo($datetime);
                $type = $this->getCategoryColor($result['category']);
                
                $this->addNotification(
                    $result['title'],
                    $timeAgo . ' - ' . $result['team_name'],
                    $type,
                    $result['id']
                );
            }
            
        } catch (PDOException $e) {
            // Handle database errors silently
            // Could log error: error_log("Database error: " . $e->getMessage());
        }
    }
    
    private function getTimeAgo(DateTime $datetime): string {
        $now = new DateTime();
        $diff = $now->diff($datetime);
        
        if ($diff->y > 0) {
            return $diff->y . ' year' . ($diff->y > 1 ? 's' : '') . ' ago';
        }
        if ($diff->m > 0) {
            return $diff->m . ' month' . ($diff->m > 1 ? 's' : '') . ' ago';
        }
        if ($diff->d > 0) {
            return $diff->d . ' day' . ($diff->d > 1 ? 's' : '') . ' ago';
        }
        if ($diff->h > 0) {
            return $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
        }
        if ($diff->i > 0) {
            return $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ago';
        }
        
        return 'just now';
    }
    
    private function getCategoryColor(string $category): string {
        // Map categories to colors
        $categoryColors = [
            'match' => 'green',
            'transfer' => 'blue',
            'injury' => 'red',
            'event' => 'yellow',
            'announcement' => 'indigo'
        ];
        
        return $categoryColors[strtolower($category)] ?? 'gray';
    }

    public function addNotification(string $message, string $time, string $type = 'blue', int $newsId = 0): void {
        $this->notifications[] = [
            'message' => $message,
            'time' => $time,
            'type' => $type,
            'id' => $newsId
        ];
        $this->notificationCount = count($this->notifications);
    }

    public function setViewAllLink(string $link): void {
        $this->viewAllLink = $link;
    }

    public function render(): string {
        $id = 'notification_' . uniqid();
        
        ob_start();
        ?>
        <div class="relative inline-block">
            <!-- Notification Button -->
            <button id="<?= $id ?>_btn" class="relative p-2 text-gray-600 hover:text-gray-800 focus:outline-none">
                <!-- Mail Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                
                <!-- Notification Count Badge -->
                <?php if ($this->notificationCount > 0): ?>
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full"><?= $this->notificationCount ?></span>
                <?php endif; ?>
            </button>

            <!-- Dropdown Dialog -->
            <div id="<?= $id ?>_dropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg z-50">
                <!-- Header -->
                <div class="px-4 py-3 border-b border-gray-200">
                    <h3 class="text-sm font-medium text-gray-700">Team News</h3>
                </div>
                
                <!-- Notification List -->
                <div class="max-h-96 overflow-y-auto">
                    <?php if (!empty($this->notifications)): ?>
                        <?php foreach ($this->notifications as $notification): ?>
                            <a href="NewsDetail.php?id=<?= $notification['id'] ?>" class="block">
                                <div class="px-4 py-3 border-b border-gray-100 hover:bg-gray-50">
                                    <div class="flex items-start">
                                        <!-- Colored Dot Based on Type -->
                                        <div class="mt-1 mr-3">
                                            <span class="inline-block w-2 h-2 rounded-full bg-<?= $notification['type'] ?>-500"></span>
                                        </div>
                                        <!-- Content -->
                                        <div>
                                            <p class="text-sm text-gray-800"><?= htmlspecialchars($notification['message']) ?></p>
                                            <p class="text-xs text-gray-500 mt-1"><?= htmlspecialchars($notification['time']) ?></p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="px-4 py-6 text-center text-gray-500 text-sm">No news from your subscribed teams</div>
                    <?php endif; ?>
                </div>
                
                <!-- Footer -->
                <div class="px-4 py-2 bg-gray-50 text-center rounded-b-md">
                    <a href="<?= htmlspecialchars($this->viewAllLink) ?>" class="text-xs text-blue-600 hover:text-blue-800">View All News</a>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const btn = document.getElementById("<?= $id ?>_btn");
                const dropdown = document.getElementById("<?= $id ?>_dropdown");
                
                // Toggle dropdown
                btn.addEventListener("click", function(e) {
                    e.stopPropagation();
                    dropdown.classList.toggle("hidden");
                });
                
                // Close when clicking outside
                document.addEventListener("click", function() {
                    dropdown.classList.add("hidden");
                });
                
                // Prevent closing when clicking inside dropdown
                dropdown.addEventListener("click", function(e) {
                    e.stopPropagation();
                });
            });
        </script>
        <?php
        return ob_get_clean();
    }
}