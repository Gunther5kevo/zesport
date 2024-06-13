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

    // Fetch match results for the selected competition
    $sql = "
        SELECT 
            rm.match_date,
            home.team_name AS home_team,
            away.team_name AS away_team,
            rm.home_score,
            rm.away_score
        FROM 
            rugby_matches rm
        INNER JOIN 
            rugby_teams home ON rm.home_team_id = home.id
        INNER JOIN 
            rugby_teams away ON rm.away_team_id = away.id
        WHERE 
            rm.match_date <= CURDATE() AND rm.competition_id = :competition_id
        ORDER BY 
            rm.match_date DESC
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
