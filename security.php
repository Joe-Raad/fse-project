
<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.html');
    exit;
}

include 'db.php';

// Fetch current user data
$user_id = $_SESSION['user']['id'];
$current_email = $_SESSION['user']['email'];

// Get current email from database
$stmt = $conn->prepare("SELECT email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
$current_email = $user_data['email'];
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Security Settings</title>
    <style>
        .container { max-width: 600px; margin: 20px auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input { width: 100%; padding: 8px; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Security Settings</h1>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="success">Settings updated successfully!</div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="error"><?php echo urldecode($_GET['error']); ?></div>
        <?php endif; ?>

        <form action="update_security.php" method="POST">
            <div class="form-group">
                <label>Email Address:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($current_email); ?>" required>
            </div>

            <div class="form-group">
                <label>New Password (leave blank to keep current):</label>
                <input type="password" name="password" placeholder="Enter new password">
            </div>

            <button type="submit">Update Security Settings</button>
        </form>
    </div>
</body>
</html>