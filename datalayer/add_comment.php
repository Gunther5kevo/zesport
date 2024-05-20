<?php
include('./server.php'); // Include your database connection

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_STRING);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);

    try {
        // Prepare and execute SQL query to insert new comment into database
        $sql = "INSERT INTO user_comments (author, content, date) VALUES (?, ?, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$author, $content]);

        // Return success response
        http_response_code(201); // Created
        echo json_encode(['message' => 'Comment added successfully']);
    } catch (PDOException $e) {
        // Handle database error
        http_response_code(500); // Internal Server Error
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    // Return error for invalid request method
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Invalid request method']);
}
?>
