<!-- File: view/components/SubscriptionStatus.php -->
<?php
// Check if user is logged in and if they are subscribed to this club
$isSubscribed = false;
if (isset($_SESSION['user']) && isset($club->id)) {
    // You would need to implement this method in your Club model
    $isSubscribed = Club::isUserSubscribed($_SESSION['user'], $club->id);
}
?>

<div class="subscription-status">
    <?php if (isset($_SESSION['user'])): ?>
        <?php if ($isSubscribed): ?>
            <div class="subscribed-badge">
                <span class="badge bg-success">Subscribed</span>
                <form method="POST" action="../controller/ClubController.php?action=unsubscribe" class="d-inline">
                    <input type="hidden" name="club_id" value="<?php echo htmlspecialchars($club->id); ?>">
                    <button type="submit" class="btn btn-sm btn-outline-danger">Unsubscribe</button>
                </form>
            </div>
        <?php else: ?>
            <form method="POST" action="../controller/ClubController.php?action=subscribe" class="d-inline">
                <input type="hidden" name="club_id" value="<?php echo htmlspecialchars($club->id); ?>">
                <button type="submit" class="btn btn-sm btn-outline-primary">Subscribe</button>
            </form>
        <?php endif; ?>
    <?php else: ?>
        <p><a href="../controller/AuthController.php?action=loginForm">Login</a> to subscribe to this club</p>
    <?php endif; ?>
</div>