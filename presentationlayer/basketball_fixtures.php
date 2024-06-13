<?php
include('../datalayer/server.php'); 

$gender = $_GET['gender'] ?? 'male'; // Default to male if not set

try {
    $sql = "
        SELECT 
            fm.match_date,
            home.team_name AS home_team,
            away.team_name AS away_team,
            fm.venue,
            fm.referee
        FROM 
            basketball_matches fm
        INNER JOIN 
            basketball_teams home ON fm.home_team_id = home.id
        INNER JOIN 
            basketball_
        INNER JOIN 
            basketball_teams away ON fm.away_team_id = away.id
        WHERE 
            fm.match_date >= CURDATE()
            AND home.gender = :gender
            AND away.gender = :gender
        ORDER BY 
            fm.match_date ASC
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['gender' => $gender]);
    $fixtures = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($fixtures)) {
        echo 'No upcoming fixtures found for ' . htmlspecialchars($gender) . ' teams.';
    } else {
        echo '<h2>Upcoming Fixtures for ' . htmlspecialchars(ucfirst($gender)) . ' Teams</h2>';
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
