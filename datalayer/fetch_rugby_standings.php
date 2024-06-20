<?php
include('../datalayer/server.php');

try {
    // Get competition_id and gender from the query parameters
    $competitionId = isset($_GET['competition_id']) ? (int)$_GET['competition_id'] : 1; // Default to 1 if not provided
    $gender = isset($_GET['gender']) ? $_GET['gender'] : 'male'; // Default to 'male' if not provided

    // Validate competitionId and gender
    if ($competitionId <= 0) {
        die('<h2>Invalid competition ID provided</h2>');
    }

    if (!in_array($gender, ['male', 'female'])) {
        die('<h2>Invalid gender provided</h2>');
    }

    // Clear the standings table for the specific competition
    $pdo->prepare("DELETE FROM rugby_standings WHERE competition_id = :competition_id")->execute(['competition_id' => $competitionId]);

    // Insert the calculated standings into the standings table
    $query = "
    INSERT INTO rugby_standings (competition_id, team_id, team_name, games_played, wins, losses, draws, points_for, points_against, points_difference, points)
    SELECT
        :competition_id AS competition_id,
        t.id AS team_id,
        t.team_name,
        COALESCE(SUM(games_played), 0) AS games_played,
        COALESCE(SUM(wins), 0) AS wins,
        COALESCE(SUM(losses), 0) AS losses,
        COALESCE(SUM(draws), 0) AS draws,
        COALESCE(SUM(points_for), 0) AS points_for,
        COALESCE(SUM(points_against), 0) AS points_against,
        COALESCE(SUM(points_difference), 0) AS points_difference,
        COALESCE(SUM(points), 0) AS points
    FROM rugby_teams t
    LEFT JOIN (
        SELECT
            team_id,
            COUNT(*) AS games_played,
            SUM(wins) AS wins,
            SUM(losses) AS losses,
            SUM(draws) AS draws,
            SUM(points_for) AS points_for,
            SUM(points_against) AS points_against,
            SUM(points_difference) AS points_difference,
            SUM(points) AS points
        FROM (
            SELECT 
                home.id AS team_id,
                1 AS games_played,
                CASE WHEN fm.home_score > fm.away_score THEN 1 ELSE 0 END AS wins,
                CASE WHEN fm.home_score < fm.away_score THEN 1 ELSE 0 END AS losses,
                CASE WHEN fm.home_score = fm.away_score THEN 1 ELSE 0 END AS draws,
                fm.home_score AS points_for,
                fm.away_score AS points_against,
                fm.home_score - fm.away_score AS points_difference,
                CASE 
                    WHEN fm.home_score > fm.away_score THEN 4 
                    WHEN fm.home_score = fm.away_score THEN 2 
                    ELSE 0 
                END AS points
            FROM 
                rugby_matches fm
            INNER JOIN 
                rugby_teams home ON fm.home_team_id = home.id
            WHERE 
                fm.match_date <= CURDATE() AND fm.competition_id = :competition_id AND home.gender = :gender AND fm.home_score IS NOT NULL AND fm.away_score IS NOT NULL

            UNION ALL

            SELECT 
                away.id AS team_id,
                1 AS games_played,
                CASE WHEN fm.away_score > fm.home_score THEN 1 ELSE 0 END AS wins,
                CASE WHEN fm.away_score < fm.home_score THEN 1 ELSE 0 END AS losses,
                CASE WHEN fm.away_score = fm.home_score THEN 1 ELSE 0 END AS draws,
                fm.away_score AS points_for,
                fm.home_score AS points_against,
                fm.away_score - fm.home_score AS points_difference,
                CASE 
                    WHEN fm.away_score > fm.home_score THEN 4 
                    WHEN fm.away_score = fm.home_score THEN 2 
                    ELSE 0 
                END AS points
            FROM 
                rugby_matches fm
            INNER JOIN 
                rugby_teams away ON fm.away_team_id = away.id
            WHERE 
                fm.match_date <= CURDATE() AND fm.competition_id = :competition_id AND away.gender = :gender AND fm.home_score IS NOT NULL AND fm.away_score IS NOT NULL
        ) AS match_results
        GROUP BY team_id
    ) AS standings ON t.id = standings.team_id
    WHERE t.gender = :gender
    GROUP BY t.id, t.team_name
    ORDER BY points DESC, points_difference DESC, team_name ASC;
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute(['competition_id' => $competitionId, 'gender' => $gender]);

    // Fetch and display the standings
    $result = $pdo->prepare("
        SELECT 
            team_id, team_name, games_played, wins, losses, draws, points_for, points_against, points_difference, points,
            @curRank := IF(@prevPoints = points AND @prevDifference = points_difference, @curRank, @curRank + 1) AS position,
            @prevPoints := points,
            @prevDifference := points_difference
        FROM 
            rugby_standings, 
            (SELECT @curRank := 0, @prevPoints := NULL, @prevDifference := NULL) AS vars
        WHERE 
            competition_id = :competition_id
        ORDER BY 
            points DESC, points_difference DESC, team_name ASC
    ");
    $result->execute(['competition_id' => $competitionId]);

    echo "<h2>Rugby Standings</h2>";
    echo "<table>
            <tr>
                <th>Position</th>
                <th>Team</th>
                <th>Games Played</th>
                <th>Wins</th>
                <th>Losses</th>
                <th>Draws</th>
                <th>Points For</th>
                <th>Points Against</th>
                <th>Points Difference</th>
                <th>Points</th>
            </tr>";

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>" . htmlspecialchars($row['position']) . "</td>
                <td>" . htmlspecialchars($row['team_name']) . "</td>
                <td>" . htmlspecialchars($row['games_played']) . "</td>
                <td>" . htmlspecialchars($row['wins']) . "</td>
                <td>" . htmlspecialchars($row['losses']) . "</td>
                <td>" . htmlspecialchars($row['draws']) . "</td>
                <td>" . htmlspecialchars($row['points_for']) . "</td>
                <td>" . htmlspecialchars($row['points_against']) . "</td>
                <td>" . htmlspecialchars($row['points_difference']) . "</td>
                <td>" . htmlspecialchars($row['points']) . "</td>
              </tr>";
    }

    echo "</table>";

} catch (PDOException $e) {
    echo '<h2>An error occurred while fetching the standings. Please try again later.</h2>';
    error_log('Database error: ' . $e->getMessage());
}
