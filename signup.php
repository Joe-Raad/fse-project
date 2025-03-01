
<?php
/*
include 'db.php';
session_start();

$data = json_decode(file_get_contents('php://input'), true);

try {
    // Check if email exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$data['email']]);
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'Email already exists']);
        exit;
    }

    // Hash password
    $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

    // Insert new user
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$data['username'], $data['email'], $hashedPassword]);

    $_SESSION['user'] = [
        'id' => $pdo->lastInsertId(),
        'username' => $data['username'],
        'email' => $data['email']
    ];

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Registration failed']);
}
    */


include 'db.php';
session_start();

$data = json_decode(file_get_contents('php://input'), true);

// Check if email exists
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $data['email']);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Email already exists']);
    exit;
}

// Hash password
$hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

// Insert new user
$stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $data['username'], $data['email'], $hashedPassword);

if ($stmt->execute()) {
    $_SESSION['user'] = [
        'id' => $stmt->insert_id,
        'username' => $data['username'],
        'email' => $data['email']
    ];
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Registration failed: ' . $conn->error]);
}

$stmt->close();
$conn->close();

?>