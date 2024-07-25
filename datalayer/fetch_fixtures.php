<?php
include('server.php'); // Include your database connection file

header('Content-Type: application/json'); // Ensure the response is JSON

try {
    // Check if both competition_id and season_id are provided
    if (isset($_GET['competition_id']) && isset($_GET['season_id'])) {
        $competition_id = $_GET['competition_id'];
        $season_id = $_GET['season_id'];

        // Fetch fixtures for the competition and season
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
                fm.competition_id = :competition_id AND
                fm.season_id = :season_id
            ORDER BY 
                fm.match_date ASC, fm.match_time ASC
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['competition_id' => $competition_id, 'season_id' => $season_id]);
        $fixtures = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Check if fixtures are found
        if (empty($fixtures)) {
            echo json_encode(['message' => 'No upcoming fixtures found for this competition and season.']);
        } else {
            // Format date and time before encoding to JSON
            foreach ($fixtures as &$fixture) {
                // Format match_date
                $match_date = date('jS F Y', strtotime($fixture['match_date']));
                $fixture['match_date'] = $match_date;

                // Format match_time
                $match_time = date('g:iA', strtotime($fixture['match_time']));
                $fixture['match_time'] = $match_time;
            }
            unset($fixture); // Unset the reference

            echo json_encode($fixtures);
        }
    } else {
        // Return error if either competition_id or season_id is missing
        echo json_encode(['error' => 'Both competition ID and season ID are required.']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}

