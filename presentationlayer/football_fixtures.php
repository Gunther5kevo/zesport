<?php
include('../datalayer/server.php'); 

try {
    
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
    fm.match_date >= CURDATE()
ORDER BY 
    fm.match_date ASC, fm.match_time ASC  
";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $fixtures = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($fixtures)) {
        echo 'No upcoming fixtures found.';
    } else {
        echo '<h2>Upcoming Fixtures</h2>';
        echo '<table>';
        echo '<tr><th>Date</th><th>Time</th><th>Home Team</th><th>Away Team</th><th>Venue</th><th>Referee</th></tr>';

        foreach ($fixtures as $fixture) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($fixture['match_date']) . '</td>';
            echo '<td>' . htmlspecialchars($fixture['match_time']) . '</td>';  // Display match_time
            echo '<td>' . htmlspecialchars($fixture['home_team']) . '</td>';
            echo '<td>' . htmlspecialchars($fixture['away_team']) . '</td>';
            echo '<td>' . htmlspecialchars($fixture['venue']) . '</td>';
            echo '<td>' . htmlspecialchars($fixture['referee']) . '</td>';
            echo '</tr>';
        }
        

        echo '</table>';
    }
} catch (PDOException $e) {
    // Handle database error
    echo 'Database error: ' . $e->getMessage();
}

?>
