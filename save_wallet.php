
<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header('Location: index.html');
    exit;
}

$user_id = $_SESSION['user']['id'];
$wallet_name = $_POST['wallet_name'];
$wallet_type = $_POST['wallet_type'];

try {
    $stmt = $conn->prepare("INSERT INTO wallet_profiles 
                          (wallet_id, wallet_name, wallet_type) 
                          VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $wallet_name, $wallet_type);
    $stmt->execute();
    
    header('Location: wallet_management.php?wallet_id=' . $user_id);
} catch (mysqli_sql_exception $e) {
    die("Error creating wallet: " . $e->getMessage());
}
?>