<?php
require_once '../../../model/News.php';
require_once 'NotificationMail.php';

class SimpleMailPage {
    private int $userId;
    private array $emails = [];
    private NotificationMailButton $notificationButton;
    
    public function __construct(int $userId) {
        $this->userId = $userId;
        $this->notificationButton = new NotificationMailButton($userId);
        $this->loadEmails();
    }
    
    private function loadEmails(): void {
        $this->emails = [];

        // Using the same News model that NotificationMailButton uses
        $news = new News();
        $news->getNewsByUserId($this->userId);
        
        // Retrieve notifications which we'll use as "emails"
        $newsNotifications = $news->getPreparedNotifications();
        
        // Convert notifications to email format
        foreach ($newsNotifications as $notification) {
            $this->emails[] = [
                'id' => $notification['id'],
                'sender' => 'System Notification', // Default sender name
                'sender_email' => 'notifications@system.com', // Default sender email
                'subject' => substr($notification['message'], 0, 50) . (strlen($notification['message']) > 50 ? '...' : ''),
                'preview' => $notification['message'],
                'date' => $notification['time'],
                'time' => date('H:i'), // You might need to extract this from your time format
                'read' => false, // Assuming all notifications are unread
                'important' => $notification['type'] === 'red', // Red notifications are important
                'type' => $notification['type'] // Store original type for color coding
            ];
        }
    }
    
    public function render(): string {
        ob_start();
        ?>

        <body class="bg-gray-100">
            <div class="container mx-auto py-8 px-4">
                <!-- Header with notification button -->
                
                <!-- Mail list -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <?php if (empty($this->emails)): ?>
                        <div class="p-8 text-center text-gray-500">
                            No messages available
                        </div>
                    <?php else: ?>
                        <!-- Mail items -->
                        <?php foreach ($this->emails as $email): ?>
                            <!-- Mail item -->
                            <div class="border-b border-gray-200 <?= $email['type'] === 'red' ? 'border-l-4 border-red-500' : ($email['type'] === 'blue' ? 'border-l-4 border-blue-500' : '') ?>">
                                <div class="flex p-4 hover:bg-gray-50 cursor-pointer" onclick="window.location.href='NewsDetail.php?id=<?= $email['id'] ?>'">
                                    <!-- Sender avatar/icon section -->
                                    <div class="flex-shrink-0 mr-4">
                                        <div class="w-12 h-12 rounded border border-<?= $email['type'] ?>-500 flex items-center justify-center text-<?= $email['type'] ?>-500">
                                            <?= strtoupper(substr($email['sender'], 0, 1)) ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Content section -->
                                    <div class="flex-grow">
                                        <!-- First line: Subject and date -->
                                        <div class="flex justify-between items-center mb-1">
                                            <h3 class="text-md font-semibold text-gray-800"><?= htmlspecialchars($email['subject']) ?></h3>
                                            <span class="text-sm text-gray-500"><?= $email['date'] ?></span>
                                        </div>
                                        
                                        <!-- Second line: Sender -->
                                        <!-- <div class="text-sm text-gray-700 mb-1">
                                            From: <?= htmlspecialchars($email['sender']) ?> &lt;<?= htmlspecialchars($email['sender_email']) ?>&gt;
                                        </div> -->
                                        
                                        <!-- Third line: Message preview -->
                                        <div class="text-sm text-gray-600">
                                            <?= htmlspecialchars($email['preview']) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <!-- Pagination (optional) -->
                <?php if (!empty($this->emails)): ?>
                <div class="mt-4 flex justify-center">
                    <nav class="inline-flex rounded-md shadow">
                        <a href="#" class="py-2 px-4 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50">Previous</a>
                        <a href="#" class="py-2 px-4 bg-white border-t border-b border-gray-300 hover:bg-gray-50">1</a>
                        <a href="#" class="py-2 px-4 bg-white border-t border-b border-gray-300 hover:bg-gray-50">2</a>
                        <a href="#" class="py-2 px-4 bg-white border-t border-b border-gray-300 hover:bg-gray-50">3</a>
                        <a href="#" class="py-2 px-4 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50">Next</a>
                    </nav>
                </div>
                <?php endif; ?>
            </div>
        </body>
        </html>
        <?php
        return ob_get_clean();
    }
}

// Example usage:
// $mailPage = new SimpleMailPage(1); // User ID
// echo $mailPage->render();