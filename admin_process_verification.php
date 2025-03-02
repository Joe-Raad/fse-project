


<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: admin.html');
    exit;
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $tier = $_POST['tier'];

    $stmt = $conn->prepare("INSERT INTO user_profiles 
                          (user_id, tier, verification_approved_at) 
                          VALUES (?, ?, NOW())
                          ON DUPLICATE KEY UPDATE 
                          tier = VALUES(tier), 
                          verification_approved_at = NOW()");
    
    $stmt->bind_param("is", $user_id, $tier);
    $stmt->execute();
}

header('Location: admin_approve.php');
exit;
?>