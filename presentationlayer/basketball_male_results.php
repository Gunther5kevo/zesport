<?php
include('../datalayer/server.php');

try {
    if (isset($_GET['competition_id']) && isset($_GET['gender'])) {
        $competition_id = $_GET['competition_id'];
        $gender = $_GET['gender'];

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
    } else {
        echo 'Invalid request. Please provide both competition ID and gender.';
    }
} catch (PDOException $e) {
    echo 'Database error: ' . $e->getMessage();
}
?>