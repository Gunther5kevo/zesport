<?php
include('../datalayer/server.php'); 

// Clear the standings table
$truncate_query = "TRUNCATE TABLE football_standings";
try {
    $pdo->exec($truncate_query);
} catch (PDOException $e) {
    die("Error truncating standings table: " . $e->getMessage());
}

// Insert the calculated standings into the standings table
$insert_query = "
INSERT INTO football_standings (team_id, team_name, played, wins, losses, draws, goals_for, goals_against, goal_difference, points)
SELECT
    team_id,
    team_name,
    COUNT(*) AS played,
    SUM(wins) AS wins,
    SUM(losses) AS losses,
    SUM(draws) AS draws,
    SUM(goals_for) AS goals_for,
    SUM(goals_against) AS goals_against,
    SUM(goals_for) - SUM(goals_against) AS goal_difference,
    SUM(points) AS points
FROM (
    SELECT 
        home.id AS team_id,
        home.team_name AS team_name,
        1 AS played,
        CASE WHEN fm.home_score > fm.away_score THEN 1 ELSE 0 END AS wins,
        CASE WHEN fm.home_score < fm.away_score THEN 1 ELSE 0 END AS losses,
        CASE WHEN fm.home_score = fm.away_score THEN 1 ELSE 0 END AS draws,
        fm.home_score AS goals_for,
        fm.away_score AS goals_against,
        CASE 
            WHEN fm.home_score > fm.away_score THEN 3 
            WHEN fm.home_score = fm.away_score THEN 1 
            ELSE 0 
        END AS points
    FROM 
        football_matches fm
    INNER JOIN 
        teams home ON fm.home_team_id = home.id
    WHERE 
        fm.match_date <= CURDATE()

    UNION ALL

    SELECT 
        away.id AS team_id,
        away.team_name AS team_name,
        1 AS played,
        CASE WHEN fm.away_score > fm.home_score THEN 1 ELSE 0 END AS wins,
        CASE WHEN fm.away_score < fm.home_score THEN 1 ELSE 0 END AS losses,
        CASE WHEN fm.away_score = fm.home_score THEN 1 ELSE 0 END AS draws,
        fm.away_score AS goals_for,
        fm.home_score AS goals_against,
        CASE 
            WHEN fm.away_score > fm.home_score THEN 3 
            WHEN fm.away_score = fm.home_score THEN 1 
            ELSE 0 
        END AS points
    FROM 
        football_matches fm
    INNER JOIN 
        teams away ON fm.away_team_id = away.id
    WHERE 
        fm.match_date <= CURDATE()
) AS match_results
GROUP BY team_id, team_name
ORDER BY points DESC, goal_difference DESC, goals_for DESC, team_name ASC
";

try {
    $pdo->exec($insert_query);
} catch (PDOException $e) {
    die("Error inserting standings: " . $e->getMessage());
}

// Fetch and display the standings
$select_query = "SELECT * FROM football_standings ORDER BY points DESC, goal_difference DESC, goals_for DESC, team_name ASC";
try {
    $stmt = $pdo->query($select_query);
    $standings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching standings: " . $e->getMessage());
}

echo "<h2>Football Standings</h2>";
echo "<table>
        <tr>
            <th>Team</th>
            <th>Played</th>
            <th>Wins</th>
            <th>Draws</th>
            <th>Losses</th>
            <th>Goals For</th>
            <th>Goals Against</th>
            <th>Goal Difference</th>
            <th>Points</th>
        </tr>";

foreach ($standings as $row) {
    echo "<tr>
            <td>{$row['team_name']}</td>
            <td>{$row['played']}</td>
            <td>{$row['wins']}</td>
            <td>{$row['draws']}</td>
            <td>{$row['losses']}</td>
            <td>{$row['goals_for']}</td>
            <td>{$row['goals_against']}</td>
            <td>{$row['goal_difference']}</td>
            <td>{$row['points']}</td>
          </tr>";
}

echo "</table>";
?>
