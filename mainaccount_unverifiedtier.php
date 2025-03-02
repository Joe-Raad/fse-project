


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

// Check if tier is unverified
if ($result->num_rows === 1) {
    $tier = $result->fetch_assoc()['tier'];
    if ($tier !== 'unverified') {
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
    <title>Standard Account</title>
    <style>
        .container { max-width: 800px; margin: 50px auto; padding: 20px; }
        .limits { margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Standard Account Access</h1>
        <div class="limits">
            <h2>Current Limitations:</h2>
            <ul>
                <li>Limited Transactions</li>
                <li>Daily Transaction Limit: $500</li>
                <li>Weekly Transaction Limit: $3500</li>
                <li>Daily Transaction Limit: $15000</li>
                <li>Standard Support Response</li>
                <li>Basic Security Features</li>
                <li>Limited Functionality</li>
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