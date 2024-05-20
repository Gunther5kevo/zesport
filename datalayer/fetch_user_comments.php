<?php
include('./server.php'); 

try {
    
    $sql = "SELECT author, content, date FROM user_comments ORDER BY date DESC LIMIT 5"; // Adjust the query as needed

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $userComments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
    header('Content-Type: application/json');
    echo json_encode($userComments);
} catch (PDOException $e) {
    
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
