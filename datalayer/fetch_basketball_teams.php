<?php
include('server.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['gender'])) {
    $gender = $_GET['gender'];

    // Fetch teams based on the provided gender
    $sql = "SELECT id, team_name FROM basketball_teams WHERE gender = :gender ORDER BY team_name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['gender' => $gender]);
    $teams = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Send the response as JSON
    header('Content-Type: application/json');
    echo json_encode($teams);
    exit;
} else {
    // Handle invalid requests
    http_response_code(400); // Bad Request
    echo json_encode(array('error' => 'Invalid request'));
    exit;
}
?>