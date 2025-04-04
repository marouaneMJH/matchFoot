<?php

require_once  '../../../model/News.php';

class NotificationMailButton {
    private int $notificationCount = 0;
    private array $notifications = [];
    private string $viewAllLink = 'Accueil.php?Target=mail';
    private int $userId;

    public function __construct(int $userId) {
        $this->userId = $userId;
        $this->loadNotifications();
        
    }

    private function loadNotifications(): void {
        $this->notifications = [];

        $news = new News();
        $news->getNewsByUserId($this->userId);

        // Retrieve prepared notifications from News object
        $newsNotifications = $news->getPreparedNotifications();
        foreach ($newsNotifications as $notif) {
            $this->addNotification($notif['message'], $notif['time'], $notif['type'], $notif['id']);
        }
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
        <!-- Notification button HTML -->
        <div class="relative">
            <button id="<?= $id ?>_button" type="button" class="p-1 bg-white text-gray-500 rounded-full hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="sr-only">View notifications</span>
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <?php if ($this->notificationCount > 0): ?>
                    <span class="absolute top-0 right-0 block h-4 w-4 rounded-full bg-red-500 text-xs text-white font-semibold"><?= $this->notificationCount ?></span>
                <?php endif; ?>
            </button>
            
            <div id="<?= $id ?>_panel" class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-200 focus:outline-none z-50" role="menu" aria-orientation="vertical" aria-labelledby="<?= $id ?>_button" tabindex="-1" style="display: none;">
                <div class="p-2" role="none">
                    <h3 class="text-sm font-medium text-gray-700">Notifications</h3>
                </div>
                
                <div class="max-h-60 overflow-y-auto" role="none">
                    <?php if (empty($this->notifications)): ?>
                        <div class="p-4 text-center text-gray-500">
                            No new notifications
                        </div>
                    <?php else: ?>
                        <?php foreach ($this->notifications as $notification): ?>
                            <a href="NewsDetail.php?id=<?= $notification['id'] ?>" class="block p-4 hover:bg-gray-50">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <span class="inline-block h-2 w-2 rounded-full bg-<?= $notification['type'] ?>-500"></span>
                                    </div>
                                    <div class="ml-3 w-0 flex-1">
                                        <p class="text-sm font-medium text-gray-900"><?= htmlspecialchars($notification['message']) ?></p>
                                        <p class="text-sm text-gray-500"><?= htmlspecialchars($notification['time']) ?></p>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <div class="p-2" role="none">
                    <a href="<?= $this->viewAllLink ?>" class="block w-full text-center px-4 py-2 text-sm text-blue-600 hover:bg-blue-50 rounded-md">
                        Voir toues les notifications
                    </a>
                </div>
            </div>
        </div>
        
        <script>
            document.getElementById('<?= $id ?>_button').addEventListener('click', function() {
                var panel = document.getElementById('<?= $id ?>_panel');
                if (panel.style.display === 'none') {
                    panel.style.display = 'block';
                } else {
                    panel.style.display = 'none';
                }
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                var button = document.getElementById('<?= $id ?>_button');
                var panel = document.getElementById('<?= $id ?>_panel');
                
                if (!button.contains(event.target) && !panel.contains(event.target)) {
                    panel.style.display = 'none';
                }
            });
        </script>
        <?php
        return ob_get_clean();
    }
}