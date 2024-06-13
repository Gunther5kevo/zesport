<?php
include('../datalayer/server.php'); 

try {
    if (isset($_GET['competition_id'])) {
        $competition_id = $_GET['competition_id'];

       
        $sql_competition = "SELECT competition_name, gender FROM basketballcompetitions WHERE id = :competition_id";
        $stmt_competition = $pdo->prepare($sql_competition);
        $stmt_competition->execute(['competition_id' => $competition_id]);
        $competition = $stmt_competition->fetch(PDO::FETCH_ASSOC);

        if ($competition) {
           
            $requiredGender = isset($_GET['gender']) ? $_GET['gender'] : 'male';
            if ($competition['gender'] !== $requiredGender) {
                echo 'The selected competition does not match the specified gender.';
                exit; // Stop further execution
            }

            echo '<h2>' . htmlspecialchars($competition['competition_name']) . '</h2>';

           
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
                    basketball_teams away ON fm.away_team_id = away.id
                WHERE 
                    fm.match_date >= CURDATE()
                    AND home.gender = :gender
                    AND away.gender = :gender
                    AND fm.competition_id = :competition_id
                ORDER BY 
                    fm.match_date ASC
            ";

            $stmt = $pdo->prepare($sql);
            $stmt->execute(['gender' => $requiredGender, 'competition_id' => $competition_id]);
            $fixtures = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($fixtures)) {
                echo 'No upcoming fixtures found !';
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
        } else {
            echo '<h2>Competition Not Found</h2>';
        }
    } else {
        echo 'No competition selected.';
    }
} catch (PDOException $e) {
    // Handle database error
    echo 'Database error: ' . $e->getMessage();
}
?>
