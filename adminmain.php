
<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: admin.html');
    exit;
}
?>
<!DOCTYPE html>
<html>
<body>
    <h1>Admin Dashboard</h1>
    <a href="logout.php">Logout</a>
</body>
</html>