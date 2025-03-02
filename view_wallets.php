
<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header('Location: index.html');
    exit;
}

$user_id = $_SESSION['user']['id'];

$stmt = $conn->prepare("SELECT * FROM wallet_profiles WHERE wallet_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Your Wallets</title>
    <style>
        .wallets-table { width: 100%; border-collapse: collapse; }
        .wallets-table th, .wallets-table td { padding: 10px; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Wallets</h1>
        <table class="wallets-table">
            <tr>
                <th>Wallet Name</th>
                <th>Type</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
            <?php while($wallet = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($wallet['wallet_name']) ?></td>
                <td><?= htmlspecialchars($wallet['wallet_type']) ?></td>
                <td><?= $wallet['created_at'] ?></td>
                <td>
                    <a href="wallet_management.php?wallet_id=<?= $wallet['wallet_id'] ?>">
                        Manage
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>