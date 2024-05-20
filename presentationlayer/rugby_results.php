<?php
include('../datalayer/server.php');

try {
    $sql = "
        SELECT 
            fm.match_date,
            home.team_name AS home_team,
            away.team_name AS away_team,
            fm.home_score,
            fm.away_score
        FROM 
            rugby_matches fm
        INNER JOIN 
            rugby_teams home ON fm.home_team_id = home.id
        INNER JOIN 
            rugby_teams away ON fm.away_team_id = away.id
        WHERE 
            fm.match_date <= CURDATE()
        ORDER BY 
            fm.match_date DESC
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<h2>Recent Results</h2>';
    echo '<table>';
    echo '<tr><th>Date</th><th>Home Team</th><th>Away Team</th><th>Score</th></tr>';

    foreach ($results as $result) {
        $homeTeam = $result['home_team'];
        $awayTeam = $result['away_team'];
        $homeScore = isset($result['home_score']) ? (int) $result['home_score'] : '-';
        $awayScore = isset($result['away_score']) ? (int) $result['away_score'] : '-';
        $score = ($homeScore !== '-' && $awayScore !== '-') ? "{$homeScore} - {$awayScore}" : '-';

        echo '<tr>';
        echo '<td>' . $result['match_date'] . '</td>';
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
