<?php
include('./server.php'); 

try {
    // Prepare and execute SQL query to fetch live scores
    $sql = "SELECT home.team_name AS homeTeam, fm.home_score AS homeScore,
                   away.team_name AS awayTeam, fm.away_score AS awayScore
            FROM football_matches fm
            INNER JOIN teams home ON fm.home_team_id = home.id
            INNER JOIN teams away ON fm.away_team_id = away.id
            WHERE fm.match_date <= NOW()
            ORDER BY fm.match_date DESC
            LIMIT 3"; 
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $liveScores = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
    header('Content-Type: application/json');
    echo json_encode($liveScores);
} catch (PDOException $e) {
    
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
