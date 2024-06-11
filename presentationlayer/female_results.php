<?php
include('../datalayer/server.php');

try {
    // Check if a competition ID is provided
    $competitionId = isset($_GET['competition_id']) ? (int)$_GET['competition_id'] : 1; // Default to competition ID 1 if not provided

    // Fetch competition name
    $sql_competition = "SELECT competition_name, gender FROM competitions WHERE id = :competition_id";
    $stmt_competition = $pdo->prepare($sql_competition);
    $stmt_competition->execute(['competition_id' => $competitionId]);
    $competition = $stmt_competition->fetch(PDO::FETCH_ASSOC);

    if ($competition) {
        echo '<h2>' . htmlspecialchars($competition['competition_name']) . '</h2>';
    } else {
        echo '<h2>Competition Not Found</h2>';
    }

    // Determine the gender to fetch match results based on competition gender
    $gender = $competition['gender'] === 'male' ? 'male' : 'female';

    // Fetch match results for the selected competition and gender
    $sql = "
        SELECT 
            fm.match_date,
            home.team_name AS home_team,
            away.team_name AS away_team,
            fm.home_score,
            fm.away_score
        FROM 
            football_matches fm
        INNER JOIN 
            teams home ON fm.home_team_id = home.id
        INNER JOIN 
            teams away ON fm.away_team_id = away.id
        WHERE 
            fm.match_date <= CURDATE() AND fm.competition_id = :competition_id
        ORDER BY 
            fm.match_date DESC
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':competition_id', $competitionId, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($results)) {
        echo 'No recent results found for this competition.';
    } else {
        echo '<table class="table table-striped">';
        echo '<thead><tr><th>Date</th><th>Home Team</th><th>Away Team</th><th>Score</th></tr></thead>';
        echo '<tbody>';

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

        echo '</tbody>';
        echo '</table>';
    }
} catch (PDOException $e) {
    echo 'Database error: ' . $e->getMessage();
}
?>
