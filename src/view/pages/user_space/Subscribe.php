<!-- File: view/Subscribe.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscribe to Club</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Subscribe to Club</h1>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success">
                <?php echo $success; ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-body">
                <h2><?php echo htmlspecialchars($club->name ?? 'Club'); ?></h2>
                <p><?php echo htmlspecialchars($club->description ?? 'Join this club to stay updated with the latest activities.'); ?></p>
                
                <form method="POST" action="../controller/ClubController.php?action=subscribe">
                    <input type="hidden" name="club_id" value="<?php echo htmlspecialchars($clubId ?? ''); ?>">
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Subscribe</button>
                        <a href="../controller/ClubController.php?action=viewClub&id=<?php echo htmlspecialchars($clubId ?? ''); ?>" class="btn btn-secondary">Back to Club</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>