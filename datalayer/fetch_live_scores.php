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
              AND home.team_name IS NOT NULL
              AND away.team_name IS NOT NULL
              AND fm.home_score IS NOT NULL
              AND fm.away_score IS NOT NULL
            ORDER BY fm.match_date DESC
            LIMIT 3";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $liveScores = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if $liveScores is not empty before sending JSON response
    if (!empty($liveScores)) {
        header('Content-Type: application/json');
        echo json_encode($liveScores);
    } else {
        echo json_encode(['error' => 'No live scores available']);
    }
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}

