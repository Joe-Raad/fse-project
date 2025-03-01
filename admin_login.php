
<?php
/*
include 'db.php';
session_start();

$data = json_decode(file_get_contents('php://input'), true);

try {
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->execute([$data['email']]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($data['password'], $admin['password'])) {
        $_SESSION['admin'] = [
            'id' => $admin['id'],
            'email' => $admin['email']
        ];
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid admin credentials']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Admin login failed']);
}
    */


    
include 'db.php';
session_start();

$data = json_decode(file_get_contents('php://input'), true);

$stmt = $conn->prepare("SELECT id, password FROM admins WHERE email = ?");
$stmt->bind_param("s", $data['email']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $admin = $result->fetch_assoc();
    if (password_verify($data['password'], $admin['password'])) {
        $_SESSION['admin'] = [
            'id' => $admin['id'],
            'email' => $data['email']
        ];
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Admin not found']);
}

$stmt->close();
$conn->close();

?>