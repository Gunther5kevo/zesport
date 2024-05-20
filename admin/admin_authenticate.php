

<?php
session_start();
include('../datalayer/server.php');
$query = "SELECT id, password FROM admin_users";
$stmt = $pdo->query($query);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Update passwords with hashing
foreach ($users as $user) {
    $hashedPassword = password_hash($user['password'], PASSWORD_DEFAULT);

    $updateQuery = "UPDATE admin_users SET hashed_password = :hashedPassword WHERE id = :userId";
    $updateStmt = $pdo->prepare($updateQuery);
    $updateStmt->execute(['hashedPassword' => $hashedPassword, 'userId' => $user['id']]);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query the database for the user
    $// Verify user credentials
$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT id, hashed_password FROM admin_users WHERE username = :username LIMIT 1";
$stmt = $pdo->prepare($query);
$stmt->execute(['username' => $username]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if ($admin && password_verify($password, $admin['hashed_password'])) {
    // Authentication successful
    $_SESSION['admin_id'] = $admin['id'];
    header('Location: admin_dashboard.php');
    exit();
} else {
    // Incorrect credentials
    header('Location: admin_login.php?error=1');
    exit();
}

}

?>
