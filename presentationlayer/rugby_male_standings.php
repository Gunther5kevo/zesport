<?php
include('../datalayer/server.php');

try {
    // Get competition_id and gender from the query parameters
    $competitionId = isset($_GET['competition_id']) ? (int)$_GET['competition_id'] : 1; // Default to 1 if not provided
    $gender = isset($_GET['gender']) ? $_GET['gender'] : 'male'; // Default to 'male' if not provided

    // Clear the standings table
    $pdo->exec("TRUNCATE TABLE rugby_standings");

    // Insert the calculated standings into the standings table
    $query = "
    INSERT INTO rugby_standings (team_id, team_name, games_played, wins, losses, draws, points_for, points_against, points_difference, points)
    SELECT
        t.id AS team_id,
        t.team_name,
        COALESCE(games_played, 0) AS games_played,
        COALESCE(wins, 0) AS wins,
        COALESCE(losses, 0) AS losses,
        COALESCE(draws, 0) AS draws,
        COALESCE(points_for, 0) AS points_for,
        COALESCE(points_against, 0) AS points_against,
        COALESCE(points_difference, 0) AS points_difference,
        COALESCE(points, 0) AS points
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
                home.team_name AS team_name,
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
                away.team_name AS team_name,
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
    WHERE t.competition_id = :competition_id AND t.gender = :gender
    ORDER BY points DESC, points_difference DESC, team_name ASC;
    ";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':competition_id', $competitionId, PDO::PARAM_INT);
    $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch and display the standings
    $result = $pdo->query("
        SELECT *,
            CASE 
                WHEN @prevPoints = points AND @prevDifference = points_difference THEN @curRank 
                WHEN (@prevPoints := points) IS NOT NULL AND (@prevDifference := points_difference) IS NOT NULL THEN @curRank := @curRank + 1 
                ELSE @curRank := @curRank + 1 
            END AS position
        FROM rugby_standings, (SELECT @curRank := 0, @prevPoints := NULL, @prevDifference := NULL) AS vars
        ORDER BY points DESC, points_difference DESC, team_name ASC
    ");

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
    echo 'Database error: ' . htmlspecialchars($e->getMessage());
}

