<?php
include('server.php'); 

try {
    // Fetch all competitions
    $sql = "SELECT id, competition_name FROM rugby_competitions ORDER BY competition_name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $competitions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output JSON response
    header('Content-Type: application/json');
    echo json_encode($competitions);
} catch (PDOException $e) {
    // Return JSON error response
    header('Content-Type: application/json', true, 500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
