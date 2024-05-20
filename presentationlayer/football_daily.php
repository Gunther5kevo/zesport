<?php

$sport = 'football';

include('../datalayer/server.php');

try {
    // SQL query to fetch recent match results for the specified sport
    $sql = "SELECT 
                fm.match_date,
                home.team_name AS home_team,
                away.team_name AS away_team,
                fm.home_score,
                fm.away_score
            FROM 
                {$sport}_matches fm
            INNER JOIN 
                {$sport}_teams home ON fm.home_team_id = home.id
            INNER JOIN 
                {$sport}_teams away ON fm.away_team_id = away.id
            WHERE 
                fm.match_date <= CURDATE()
            ORDER BY 
                fm.match_date DESC
            LIMIT 5";

    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
    header('Content-Type: application/json');
    echo json_encode($results);
} catch (PDOException $e) {
    // Handle database error
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => 'Database error']);
}
?>
