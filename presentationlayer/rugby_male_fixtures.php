<?php
include('../datalayer/server.php');

try {
    // Check if a competition ID is provided
    $competitionId = isset($_GET['competition_id']) ? (int)$_GET['competition_id'] : 1; // Default to competition ID 1 if not provided

    // Fetch competition name and gender
    $sql_competition = "SELECT competition_name, gender FROM rugby_competitions WHERE id = :competition_id";
    $stmt_competition = $pdo->prepare($sql_competition);
    $stmt_competition->execute(['competition_id' => $competitionId]);
    $competition = $stmt_competition->fetch(PDO::FETCH_ASSOC);

    if ($competition) {
        echo '<h2>' . htmlspecialchars($competition['competition_name']) . '</h2>';
    } else {
        echo '<h2>Competition Not Found</h2>';
        exit; // Exit if the competition is not found
    }

    
    $sql = "
        SELECT 
            fm.match_date,
            home.team_name AS home_team,
            away.team_name AS away_team,
            fm.venue,
            fm.referee
        FROM 
            rugby_matches fm
        INNER JOIN 
            rugby_teams home ON fm.home_team_id = home.id
        INNER JOIN 
            rugby_teams away ON fm.away_team_id = away.id
        WHERE 
            fm.match_date >= CURDATE() AND fm.competition_id = :competition_id
        ORDER BY 
            fm.match_date ASC
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':competition_id', $competitionId, PDO::PARAM_INT);
    $stmt->execute();
    $fixtures = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($fixtures)) {
        echo 'No upcoming fixtures found for this competition.';
    } else {
        echo '<table class="table table-striped">';
        echo '<thead><tr><th>Date</th><th>Home Team</th><th>Away Team</th><th>Venue</th><th>Referee</th></tr></thead>';
        echo '<tbody>';

        foreach ($fixtures as $fixture) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($fixture['match_date']) . '</td>';
            echo '<td>' . htmlspecialchars($fixture['home_team']) . '</td>';
            echo '<td>' . htmlspecialchars($fixture['away_team']) . '</td>';
            echo '<td>' . htmlspecialchars($fixture['venue']) . '</td>';
            echo '<td>' . htmlspecialchars($fixture['referee']) . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    }
} catch (PDOException $e) {
    // Handle database error
    echo 'Database error: ' . $e->getMessage();
}
?>
