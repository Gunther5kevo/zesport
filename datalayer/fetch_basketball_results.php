<?php
include('server.php'); // Include your database connection file

header('Content-Type: application/json'); // Ensure the response is JSON

try {
    if (isset($_GET['competition_id'])) {
        $competition_id = $_GET['competition_id'];

        // Fetch competition details including gender
        $sql_competition = "SELECT competition_name, gender FROM basketballcompetitions WHERE id = :competition_id";
        $stmt_competition = $pdo->prepare($sql_competition);
        $stmt_competition->execute(['competition_id' => $competition_id]);
        $competition = $stmt_competition->fetch(PDO::FETCH_ASSOC);

        if (!$competition) {
            echo json_encode(['error' => 'Competition not found.']);
            exit;
        }

        // Fetch past results
        $sql_past_results = "
            SELECT 
                fm.match_date,
                home.team_name AS home_team,
                away.team_name AS away_team,
                fm.home_score,
                fm.away_score,
                fm.venue,
                fm.referee
            FROM 
                basketball_matches fm
            INNER JOIN 
                basketball_teams home ON fm.home_team_id = home.id
            INNER JOIN 
                basketball_teams away ON fm.away_team_id = away.id
            WHERE 
                fm.match_date < CURDATE()
                AND fm.competition_id = :competition_id
                AND fm.home_score IS NOT NULL
                AND fm.away_score IS NOT NULL
            ORDER BY 
                fm.match_date DESC
        ";

        $stmt_past_results = $pdo->prepare($sql_past_results);
        $stmt_past_results->execute(['competition_id' => $competition_id]);
        $past_results = $stmt_past_results->fetchAll(PDO::FETCH_ASSOC);

        if (empty($past_results)) {
            echo json_encode(['message' => 'No past results found for this competition.']);
        } else {
            // Format the match_date
            foreach ($past_results as &$result) {
                $date = new DateTime($result['match_date']);
                $result['match_date'] = $date->format('jS F Y'); 
            }

            echo json_encode($past_results);
        }

    } else {
        echo json_encode(['error' => 'No competition ID provided.']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}

