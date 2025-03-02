
<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header('Location: index.html');
    exit;
}

$user_id = $_SESSION['user']['id'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create New Wallet</title>
    <style>
        .wallet-form { max-width: 400px; margin: 50px auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input, select { width: 100%; padding: 8px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Create New Wallet</h1>
        <form action="save_wallet.php" method="POST">
            <div class="form-group">
                <label>Wallet Name:</label>
                <input type="text" name="wallet_name" required>
            </div>
            
            <div class="form-group">
                <label>Wallet Type:</label>
                <select name="wallet_type" required>
                    <option value="personal">Personal</option>
                    <option value="business">Business</option>
                    <option value="savings">Savings</option>
                </select>
            </div>
            
            <button type="submit">Create Wallet</button>
        </form>
    </div>
</body>
</html>