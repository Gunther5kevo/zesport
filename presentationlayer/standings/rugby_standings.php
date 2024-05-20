<?php
include('../datalayer/server.php');

try {
    // Clear the standings table
    $pdo->exec("TRUNCATE TABLE rugby_standings");

    // Insert the calculated standings into the standings table
    $query = "
    INSERT INTO rugby_standings (team_id, team_name, games_played, wins, losses, draws, points_for, points_against, points_difference, points)
    SELECT
        team_id,
        team_name,
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
            fm.match_date <= CURDATE()

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
            fm.match_date <= CURDATE()
    ) AS match_results
    GROUP BY team_id, team_name
    ORDER BY points DESC, points_difference DESC, team_name ASC
    ";

    $pdo->exec($query);

    // Fetch and display the standings
    $result = $pdo->query("SELECT * FROM rugby_standings ORDER BY points DESC, points_difference DESC, team_name ASC");

    echo "<h2>Rugby Standings</h2>";
    echo "<table>
            <tr>
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
                <td>{$row['team_name']}</td>
                <td>{$row['games_played']}</td>
                <td>{$row['wins']}</td>
                <td>{$row['losses']}</td>
                <td>{$row['draws']}</td>
                <td>{$row['points_for']}</td>
                <td>{$row['points_against']}</td>
                <td>{$row['points_difference']}</td>
                <td>{$row['points']}</td>
              </tr>";
    }

    echo "</table>";
} catch (PDOException $e) {
    echo 'Database error: ' . $e->getMessage();
}
?>
