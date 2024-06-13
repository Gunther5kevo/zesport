<?php
include('server.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['gender'])) {
    $gender = $_GET['gender'];

    
    $sql = "SELECT id, team_name FROM rugby_teams WHERE gender = :gender ORDER BY team_name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['gender' => $gender]);
    $teams = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
    header('Content-Type: application/json');
    echo json_encode($teams);
    exit;
} else {
    
    http_response_code(400); 
    echo json_encode(array('error' => 'Invalid request'));
    exit;
}


?>
