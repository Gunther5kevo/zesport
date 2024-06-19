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

        // Ensure gender matches if provided in the query
        $requiredGender = isset($_GET['gender']) ? $_GET['gender'] : $competition['gender'];
        if ($competition['gender'] !== $requiredGender) {
            echo json_encode(['error' => 'The selected competition does not match the specified gender.']);
            exit;
        }

        // Fetch upcoming fixtures
        $sql_upcoming_fixtures = "
            SELECT 
                fm.match_date,
                fm.match_time,
                home.team_name AS home_team,
                away.team_name AS away_team,
                fm.venue,
                fm.referee
            FROM 
                basketball_matches fm
            INNER JOIN 
                basketball_teams home ON fm.home_team_id = home.id
            INNER JOIN 
                basketball_teams away ON fm.away_team_id = away.id
            WHERE 
                fm.match_date >= CURDATE()
                AND home.gender = :gender
                AND away.gender = :gender
                AND fm.competition_id = :competition_id
            ORDER BY 
                fm.match_date ASC, fm.match_time ASC
        ";

        $stmt_upcoming_fixtures = $pdo->prepare($sql_upcoming_fixtures);
        $stmt_upcoming_fixtures->execute(['gender' => $requiredGender, 'competition_id' => $competition_id]);
        $upcoming_fixtures = $stmt_upcoming_fixtures->fetchAll(PDO::FETCH_ASSOC);

        if (empty($upcoming_fixtures)) {
            echo json_encode(['message' => 'No upcoming fixtures found for this competition.']);
        } else {
            echo json_encode($upcoming_fixtures);
        }

    } else {
        echo json_encode(['error' => 'No competition ID provided.']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}

