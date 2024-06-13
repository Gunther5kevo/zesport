<?php
include('../datalayer/server.php');

try {
    // Query to find basketball competitions for females
    $sql_competition = "SELECT id, competition_name, gender FROM basketballcompetitions WHERE gender = 'female'";
    $stmt_competition = $pdo->prepare($sql_competition);
    $stmt_competition->execute();
    $competition = $stmt_competition->fetch(PDO::FETCH_ASSOC);

    if ($competition) {
        $competition_id = $competition['id'];
        $gender = 'female'; // Setting gender as female since the competition is for females
    } else {
        die('<h2>No Female Basketball Competition Found</h2>');
    }

    $sql = "
        SELECT 
            fm.match_date,
            home.team_name AS home_team,
            away.team_name AS away_team,
            fm.home_score,
            fm.away_score
        FROM 
            basketball_matches fm
        INNER JOIN 
            basketball_teams home ON fm.home_team_id = home.id
        INNER JOIN 
            basketball_teams away ON fm.away_team_id = away.id
        WHERE 
            fm.match_date <= CURDATE()
            AND fm.competition_id = :competition_id
            AND (home.gender = :gender AND away.gender = :gender)
        ORDER BY 
            fm.match_date DESC
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['competition_id' => $competition_id, 'gender' => $gender]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<h2>Recent Results</h2>';
    echo '<table>';
    echo '<tr><th>Date</th><th>Home Team</th><th>Away Team</th><th>Score</th></tr>';

    foreach ($results as $result) {
        $homeTeam = htmlspecialchars($result['home_team']);
        $awayTeam = htmlspecialchars($result['away_team']);
        $homeScore = isset($result['home_score']) ? (int) $result['home_score'] : '-';
        $awayScore = isset($result['away_score']) ? (int) $result['away_score'] : '-';
        $score = ($homeScore !== '-' && $awayScore !== '-') ? "{$homeScore} - {$awayScore}" : '-';

        echo '<tr>';
        echo '<td>' . htmlspecialchars($result['match_date']) . '</td>';
        echo '<td>' . $homeTeam . '</td>';
        echo '<td>' . $awayTeam . '</td>';
        echo '<td>' . $score . '</td>';
        echo '</tr>';
    }

    echo '</table>';
} catch (PDOException $e) {
    echo 'Database error: ' . $e->getMessage();
}
?>
