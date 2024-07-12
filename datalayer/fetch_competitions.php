<?php
include('server.php'); // Include your database connection script

header('Content-Type: application/json');

try {
    // Check if season parameter is provided in the request
    if (isset($_GET['season'])) {
        $season = $_GET['season'];

        // Fetch competitions for the specified season using season_id
        $sql = "
            SELECT id, competition_name
            FROM competitions
            WHERE season_id = :season_id
            ORDER BY competition_name
        ";

        // Prepare and execute the SQL statement
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['season_id' => $season]);

        // Fetch all rows as associative array
        $competitions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if any competitions were found
        if ($competitions) {
            // Output JSON response with competitions data
            echo json_encode($competitions);
        } else {
            // Handle case where no competitions are found for the given season_id
            echo json_encode(['error' => 'No competitions found for this season.']);
        }
    } else {
        // Handle case where season parameter is not provided in the request
        echo json_encode(['error' => 'No season provided.']);
    }
} catch (PDOException $e) {
    // Handle database errors
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}

