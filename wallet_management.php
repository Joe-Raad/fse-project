
<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header('Location: index.html');
    exit;
}

$wallet_id = $_GET['wallet_id'] ?? null;
$user_id = $_SESSION['user']['id'];

// Verify wallet ownership
$stmt = $conn->prepare("SELECT wallet_name FROM wallet_profiles 
                       WHERE wallet_id = ? AND wallet_id = ?");
$stmt->bind_param("ii", $wallet_id, $user_id);
$stmt->execute();
$wallet = $stmt->get_result()->fetch_assoc();

if (!$wallet) {
    header('Location: view_wallets.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Wallet Management</title>
    <style>
        .functionality-section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; }
        .wallet-name { text-align: center; font-size: 24px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="wallet-name"><?= htmlspecialchars($wallet['wallet_name']) ?></h1>
        
        <div class="functionality-section">
            <h2>DEPOSIT</h2>
            <!-- Add deposit functionality here -->
        </div>
        
        <div class="functionality-section">
            <h2>WITHDRAW</h2>
            <!-- Add withdraw functionality here -->
        </div>
        
        <div class="functionality-section">
            <h2>TRANSFER</h2>
            <!-- Add transfer functionality here -->
        </div>
        
        <div class="functionality-section">
            <h2>SCHEDULED PAYMENTS</h2>
            <!-- Add scheduled payments functionality here -->
        </div>
        
        <div class="functionality-section">
            <h2>QR CODE PAYMENTS</h2>
            <!-- Add QR code functionality here -->
        </div>
        
        <div class="functionality-section">
            <h2>TRANSACTION HISTORY</h2>
            <!-- Add transaction history functionality here -->
        </div>
        
        <a href="view_wallets.php">Back to Wallets</a>
    </div>
</body>
</html>