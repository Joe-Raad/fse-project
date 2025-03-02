


<?php
session_start();
require 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: index.html');
    exit;
}

$user_id = $_SESSION['user']['id'];

// Verify tier status
$stmt = $conn->prepare("SELECT tier FROM user_profiles WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if tier is verified
if ($result->num_rows === 1) {
    $tier = $result->fetch_assoc()['tier'];
    if ($tier !== 'verified') {
        header('Location: accountlimit.php');
        exit;
    }
} else {
    // No tier status found
    header('Location: accountlimit.php');
    exit;
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Verified Account</title>
    <style>
        .container { max-width: 800px; margin: 50px auto; padding: 20px; }
        .features { margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Verified Tier</h1>
        <div class="features">
            <h2>Premium Features:</h2>
            <ul>
                <li>Unlimited Transactions</li>
                <li>Daily Transaction Limit: $2000</li>
                <li>Weekly Transaction Limit: $14000</li>
                <li>Monthly Transaction Limit: $60,000</li>
                <li>Priority Support</li>
                <li>Enhanced Security</li>
                <li>Exclusive Offers</li>
            </ul>
        </div>
        <!-- Add this inside the <div class="container"> after the features list -->
        <div class="wallet-actions" style="margin-top: 30px;">
            <a href="create_wallet.php" class="btn">Create New Wallet</a>
            <a href="view_wallets.php" class="btn">View Existing Wallets</a>
        </div>
        <a href="profile.php">Back to Profile</a>
    </div>
</body>
</html>