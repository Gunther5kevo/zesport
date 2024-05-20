<?php
include('../datalayer/server.php'); 

try {
    
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
            fm.match_date >= CURDATE()
        ORDER BY 
            fm.match_date ASC
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $fixtures = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($fixtures)) {
        echo 'No upcoming fixtures found.';
    } else {
        echo '<h2>Upcoming Rugby Fixtures</h2>';
        echo '<table>';
        echo '<tr><th>Date</th><th>Home Team</th><th>Away Team</th><th>Venue</th><th>Referee</th></tr>';

        foreach ($fixtures as $fixture) {
            echo '<tr>';
            echo '<td>' . $fixture['match_date'] . '</td>';
            echo '<td>' . $fixture['home_team'] . '</td>';
            echo '<td>' . $fixture['away_team'] . '</td>';
            echo '<td>' . $fixture['venue'] . '</td>';
            echo '<td>' . $fixture['referee'] . '</td>';
            echo '</tr>';
        }

        echo '</table>';
    }
} catch (PDOException $e) {
    // Handle database error
    echo 'Database error: ' . $e->getMessage();
}

?>
