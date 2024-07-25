<?php
include('server.php');

header('Content-Type: application/json');

try {
    // Check if competition ID and season ID are provided
    if (isset($_GET['competition_id']) && isset($_GET['season_id'])) {
        $competitionId = $_GET['competition_id'];
        $seasonId = $_GET['season_id'];

        // Fetch match results for the selected competition and season
        $sql = "
            SELECT 
                fm.match_date,
                home.team_name AS home_team,
                away.team_name AS away_team,
                fm.home_score,
                fm.away_score
            FROM 
                football_matches fm
            INNER JOIN 
                teams home ON fm.home_team_id = home.id
            INNER JOIN 
                teams away ON fm.away_team_id = away.id
            WHERE 
                fm.match_date <= CURDATE() AND 
                fm.competition_id = :competition_id AND 
                fm.season_id = :season_id AND 
                fm.home_score IS NOT NULL AND 
                fm.away_score IS NOT NULL
            ORDER BY 
                fm.match_date DESC
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['competition_id' => $competitionId, 'season_id' => $seasonId]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Format the match_date
        foreach ($results as &$result) {
            $date = new DateTime($result['match_date']);
            $result['match_date'] = $date->format('jS F Y');
        }

        echo json_encode($results);
    } else {
        // Handle case where competition_id or season_id are not provided
        echo json_encode(['error' => 'Both competition ID and season ID are required.']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}

