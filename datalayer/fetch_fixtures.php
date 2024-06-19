<?php
include('server.php'); 

header('Content-Type: application/json'); // Ensure the response is JSON

try {
    if (isset($_GET['competition_id'])) {
        $competition_id = $_GET['competition_id'];

        // Fetch fixtures for the competition
        $sql = "
            SELECT 
                fm.match_date,
                fm.match_time,
                home.team_name AS home_team,
                away.team_name AS away_team,
                fm.venue,
                fm.referee
            FROM 
                football_matches fm
            INNER JOIN 
                teams home ON fm.home_team_id = home.id
            INNER JOIN 
                teams away ON fm.away_team_id = away.id
            WHERE 
                fm.match_date >= CURDATE() AND
                fm.competition_id = :competition_id
            ORDER BY 
                fm.match_date ASC, fm.match_time ASC
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['competition_id' => $competition_id]);
        $fixtures = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if fixtures are found
        if (empty($fixtures)) {
            echo json_encode(['message' => 'No upcoming fixtures found for this competition.']);
        } else {
            echo json_encode($fixtures);
        }
    } else {
        echo json_encode(['error' => 'No competition ID provided.']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
