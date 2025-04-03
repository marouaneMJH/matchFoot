<?php

class NotificationMailButton {
    private int $notificationCount;
    private array $notifications;
    private ?string $viewAllLink = null;

    public function __construct(int $notificationCount = 0, array $notifications = []) {
        $this->notificationCount = $notificationCount;
        $this->notifications = $notifications;
    }

    public function setNotificationCount(int $count): void {
        $this->notificationCount = $count;
    }

    public function addNotification(string $message, string $time, string $type = 'blue', ?string $icon = null): void {
        $icon = $icon ?? $this->getDefaultIcon($type);
        $this->notifications[] = compact('message', 'time', 'type', 'icon');
        $this->notificationCount = count($this->notifications);
    }

    public function clearNotifications(): void {
        $this->notifications = [];
        $this->notificationCount = 0;
    }

    public function setViewAllLink(string $link): void {
        $this->viewAllLink = $link;
    }

    private function getDefaultIcon(string $type): string {
        $icons = [
            'green' => '<svg ...>...</svg>',
            'yellow' => '<svg ...>...</svg>',
            'blue' => '<svg ...>...</svg>',
        ];
        return $icons[$type] ?? $icons['blue'];
    }

    public function render(): string {
        $id = uniqid('notification_');
        $buttonId = "{$id}_button";
        $dialogId = "{$id}_dialog";
        $countId = "{$id}_count";

        ob_start();
        ?>
        <div class="relative inline-block">
            <button id="<?= $buttonId ?>" class="relative ...">
                <svg ...>...</svg>
                <?php if ($this->notificationCount > 0): ?>
                    <div id="<?= $countId ?>" class="absolute ..."><?= $this->notificationCount ?></div>
                <?php endif; ?>
            </button>

            <div id="<?= $dialogId ?>" class="hidden absolute ...">
                <div class="p-4 border-b ...">
                    <h3 class="font-semibold ...">Notifications</h3>
                </div>
                <div class="max-h-96 overflow-y-auto">
                    <?php if (!empty($this->notifications)): ?>
                        <?php foreach ($this->notifications as $index => $notification): ?>
                            <div class="p-4 <?= $index < count($this->notifications) - 1 ? 'border-b' : '' ?> hover:bg-gray-50 ...">
                                <div class="flex items-start">
                                    <div class="h-8 w-8 rounded-full bg-<?= $notification['type'] ?>-100 ...">
                                        <?= $notification['icon'] ?>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium ..."><?= htmlspecialchars($notification['message']) ?></p>
                                        <p class="text-xs text-gray-500 ..."><?= htmlspecialchars($notification['time']) ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="p-4 text-center text-gray-500">No notifications</div>
                    <?php endif; ?>
                </div>
                <div class="p-3 bg-gray-50 text-center">
                    <a href="<?= $this->viewAllLink ?? '#' ?>" class="text-sm text-blue-600 ...">View all notifications</a>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const notificationButton = document.getElementById("<?= $buttonId ?>");
                const notificationDialog = document.getElementById("<?= $dialogId ?>");

                notificationButton.addEventListener("click", function() {
                    notificationDialog.classList.toggle("hidden");
                });

                document.addEventListener("click", function(event) {
                    if (!notificationButton.contains(event.target) && !notificationDialog.contains(event.target)) {
                        notificationDialog.classList.add("hidden");
                    }
                });
            });
        </script>
        <?php
        return ob_get_clean();
    }
}
