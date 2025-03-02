
<?php /*
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.html');
    exit;
}  */
?>
<!DOCTYPE html>
<html> <!--
<body>
    <h1>Welcome <?php echo $_SESSION['user']['username']; ?></h1>
    <a href="logout.php">Logout</a>
</body>  -->
</html>

<?php // code to be able to upload files   
if (!is_dir('uploads')) {
    mkdir('uploads', 0755, true);
}
?>

<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.html');
    exit;
}

include 'db.php';

// Fetch existing profile data
$user_id = $_SESSION['user']['id'];
$profile_data = [];
$stmt = $conn->prepare("SELECT * FROM user_profiles WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $profile_data = $result->fetch_assoc();
}
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <style>
        .container { max-width: 600px; margin: 20px auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input, textarea { width: 100%; padding: 8px; }
        .file-upload { margin: 10px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Profile Management</h1>
        <form action="save_profile.php" method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($profile_data['username'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label>ID Document (PDF/Image):</label>
                <input type="file" class="file-upload" name="id_document" accept=".pdf,.jpg,.jpeg,.png">
                <?php if (!empty($profile_data['id_document'])): ?>
                    <p>Current file: <?php echo basename($profile_data['id_document']); ?></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Address:</label>
                <textarea name="address"><?php echo htmlspecialchars($profile_data['address'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label>Phone Number:</label>
                <input type="tel" name="phone" value="<?php echo htmlspecialchars($profile_data['phone'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label>Facebook Profile:</label>
                <input type="url" name="facebook" value="<?php echo htmlspecialchars($profile_data['facebook'] ?? ''); ?>">
            </div>

            <button type="submit">Save Profile</button>
        </form>

        <div style="margin-top: 20px;">
            <a href="accountlimit.php" class="btn">Account Limits</a>
        </div>
    </div>
    
    <!--  link to reach security page          -->
    <a href="security.php" class="btn">Security Settings</a>
</body>
</html>