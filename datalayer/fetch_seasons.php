<?php
include('server.php'); // Include your database connection script

header('Content-Type: application/json');

try {
    // Fetch all seasons
    $sql = "SELECT * FROM seasons";
    $stmt = $pdo->query($sql);
    $seasons = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output JSON response
    echo json_encode($seasons);
} catch (PDOException $e) {
    // Handle database errors
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}

