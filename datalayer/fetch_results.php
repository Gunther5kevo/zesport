<?php
include('server.php');

try {
    // Check if a competition ID is provided
    $competitionId = isset($_GET['competition_id']) ? (int)$_GET['competition_id'] : 1; // Default to competition ID 1 if not provided

    // Fetch competition name
    $sql_competition = "SELECT competition_name, gender FROM competitions WHERE id = :competition_id";
    $stmt_competition = $pdo->prepare($sql_competition);
    $stmt_competition->execute(['competition_id' => $competitionId]);
    $competition = $stmt_competition->fetch(PDO::FETCH_ASSOC);

    // Determine the gender to fetch match results based on competition gender
    $gender = $competition['gender'] === 'male' ? 'male' : 'male';

    // Fetch match results for the selected competition and gender
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
            fm.home_score IS NOT NULL AND 
            fm.away_score IS NOT NULL
        ORDER BY 
            fm.match_date DESC
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':competition_id', $competitionId, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format the match_date
    foreach ($results as &$result) {
        $date = new DateTime($result['match_date']);
        $result['match_date'] = $date->format('jS F Y'); // Formats date as "6th June 2024"
    }

    // Return results as JSON
    header('Content-Type: application/json');
    echo json_encode($results);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
