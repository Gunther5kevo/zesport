<?php
include('../datalayer/server.php');

try {
    if (isset($_GET['competition_id'])) {
        $competition_id = $_GET['competition_id'];
        $sql_competition = "SELECT competition_name FROM competitions WHERE id = :competition_id";
        $stmt_competition = $pdo->prepare($sql_competition);
        $stmt_competition->execute(['competition_id' => $competition_id]);
        $competition = $stmt_competition->fetch(PDO::FETCH_ASSOC);

        echo '<h2>' . htmlspecialchars($competition['competition_name']) . '</h2>';

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
                home.gender = 'Female' AND 
                away.gender = 'Female' AND
                fm.competition_id = :competition_id
            ORDER BY 
                fm.match_date ASC, fm.match_time ASC
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['competition_id' => $competition_id]);
        $fixtures = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($fixtures)) {
            echo 'No upcoming fixtures found for this competition.';
        } else {
            echo '<table class="table table-striped">';
            echo '<thead><tr><th>Date</th><th>Time</th><th>Home Team</th><th>Away Team</th><th>Venue</th><th>Referee</th></tr></thead>';
            echo '<tbody>';

            foreach ($fixtures as $fixture) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($fixture['match_date']) . '</td>';
                echo '<td>' . htmlspecialchars($fixture['match_time']) . '</td>';
                echo '<td>' . htmlspecialchars($fixture['home_team']) . '</td>';
                echo '<td>' . htmlspecialchars($fixture['away_team']) . '</td>';
                echo '<td>' . htmlspecialchars($fixture['venue']) . '</td>';
                echo '<td>' . htmlspecialchars($fixture['referee']) . '</td>';
                echo '</tr>';
            }

            echo '</tbody></table>';
        }
    } else {
        echo 'No competition selected.';
    }
} catch (PDOException $e) {
    echo 'Database error: ' . $e->getMessage();
}
?>
