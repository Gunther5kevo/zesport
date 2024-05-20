<?php
include('../datalayer/server.php');

try {
    // Clear the standings table
    $pdo->exec("TRUNCATE TABLE basketball_standings");

    // Insert the calculated standings into the standings table
    $query = "
    INSERT INTO basketball_standings (team_id, team_name, games_played, wins, losses, points_for, points_against, win_percentage)
    SELECT
        team_id,
        team_name,
        COUNT(*) AS games_played,
        SUM(wins) AS wins,
        SUM(losses) AS losses,
        SUM(points_for) AS points_for,
        SUM(points_against) AS points_against,
        ROUND(SUM(wins) / COUNT(*), 3) AS win_percentage
    FROM (
        SELECT 
            home.id AS team_id,
            home.team_name AS team_name,
            1 AS games_played,
            CASE WHEN fm.home_score > fm.away_score THEN 1 ELSE 0 END AS wins,
            CASE WHEN fm.home_score < fm.away_score THEN 1 ELSE 0 END AS losses,
            fm.home_score AS points_for,
            fm.away_score AS points_against
        FROM 
            basketball_matches fm
        INNER JOIN 
            basketball_teams home ON fm.home_team_id = home.id
        WHERE 
            fm.match_date <= CURDATE()

        UNION ALL

        SELECT 
            away.id AS team_id,
            away.team_name AS team_name,
            1 AS games_played,
            CASE WHEN fm.away_score > fm.home_score THEN 1 ELSE 0 END AS wins,
            CASE WHEN fm.away_score < fm.home_score THEN 1 ELSE 0 END AS losses,
            fm.away_score AS points_for,
            fm.home_score AS points_against
        FROM 
            basketball_matches fm
        INNER JOIN 
            basketball_teams away ON fm.away_team_id = away.id
        WHERE 
            fm.match_date <= CURDATE()
    ) AS match_results
    GROUP BY team_id, team_name
    ORDER BY win_percentage DESC, points_for DESC, points_against ASC, team_name ASC
    ";

    $pdo->exec($query);

    // Fetch and display the standings
    $result = $pdo->query("SELECT * FROM basketball_standings ORDER BY win_percentage DESC, points_for DESC, points_against ASC, team_name ASC");

    echo "<h2>Basketball Standings</h2>";
    echo "<table>
            <tr>
                <th>Team</th>
                <th>Games Played</th>
                <th>Wins</th>
                <th>Losses</th>
                <th>Points For</th>
                <th>Points Against</th>
                <th>Win Percentage</th>
            </tr>";

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>
                <td>{$row['team_name']}</td>
                <td>{$row['games_played']}</td>
                <td>{$row['wins']}</td>
                <td>{$row['losses']}</td>
                <td>{$row['points_for']}</td>
                <td>{$row['points_against']}</td>
                <td>" . number_format($row['win_percentage'], 3) . "</td>
              </tr>";
    }

    echo "</table>";
} catch (PDOException $e) {
    echo 'Database error: ' . $e->getMessage();
}
?>
