<?php
include('../datalayer/server.php'); 

// Fetch competition name and gender (male only)
$sql_competition = "SELECT id, competition_name, gender FROM competitions WHERE gender = 'male'";
$stmt_competition = $pdo->prepare($sql_competition);
$stmt_competition->execute();
$competition = $stmt_competition->fetch(PDO::FETCH_ASSOC);

if ($competition) {
    $competitionId = $competition['id'];
    echo '<h2>' . htmlspecialchars($competition['competition_name']) . '</h2>';
} else {
    die('<h2>No Male Competition Found</h2>');
}

// Clear the standings table
$truncate_query = "TRUNCATE TABLE male_standings";
try {
    $pdo->exec($truncate_query);
} catch (PDOException $e) {
    die("Error truncating standings table: " . $e->getMessage());
}

// Insert the calculated standings into the standings table
$insert_query = "
INSERT INTO male_standings (team_id, competition_id, played, won, drawn, lost, goals_for, goals_against, goal_difference, points)
SELECT
    team_id,
    :competition_id AS competition_id,
    COUNT(*) AS played,
    SUM(wins) AS won,
    SUM(draws) AS drawn,
    SUM(losses) AS lost,
    SUM(goals_for) AS goals_for,
    SUM(goals_against) AS goals_against,
    SUM(goals_for) - SUM(goals_against) AS goal_difference,
    SUM(points) AS points
FROM (
    SELECT 
        home.id AS team_id,
        1 AS played,
        CASE WHEN fm.home_score > fm.away_score THEN 1 ELSE 0 END AS wins,
        CASE WHEN fm.home_score = fm.away_score THEN 1 ELSE 0 END AS draws,
        CASE WHEN fm.home_score < fm.away_score THEN 1 ELSE 0 END AS losses,
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
        fm.competition_id = :competition_id AND
        fm.match_date <= CURDATE() AND
        home.gender = 'male'

    UNION ALL

    SELECT 
        away.id AS team_id,
        1 AS played,
        CASE WHEN fm.away_score > fm.home_score THEN 1 ELSE 0 END AS wins,
        CASE WHEN fm.away_score = fm.home_score THEN 1 ELSE 0 END AS draws,
        CASE WHEN fm.away_score < fm.home_score THEN 1 ELSE 0 END AS losses,
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
        fm.competition_id = :competition_id AND
        fm.match_date <= CURDATE() AND
        away.gender = 'male'
) AS match_results
GROUP BY team_id
ORDER BY points DESC, goal_difference DESC, goals_for DESC
";

try {
    $stmt = $pdo->prepare($insert_query);
    $stmt->execute(['competition_id' => $competitionId]);
} catch (PDOException $e) {
    die("Error inserting standings: " . $e->getMessage());
}

// Fetch and display the standings
$select_query = "
SELECT 
    ROW_NUMBER() OVER () AS position,
    teams.team_name,
    male_standings.played,
    male_standings.won,
    male_standings.drawn,
    male_standings.lost,
    male_standings.goals_for,
    male_standings.goals_against,
    male_standings.goal_difference,
    male_standings.points
FROM 
    male_standings
INNER JOIN 
    teams ON male_standings.team_id = teams.id
WHERE
    male_standings.competition_id = :competition_id
ORDER BY 
    male_standings.points DESC, 
    male_standings.goal_difference DESC, 
    male_standings.goals_for DESC
";

try {
    $stmt = $pdo->prepare($select_query);
    $stmt->execute(['competition_id' => $competitionId]);
    $standings = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching standings: " . $e->getMessage());
}

echo "<table>
        <tr>
            <th>Position</th>
            <th>Team</th>
            <th>P</th>
            <th>W</th>
            <th>D</th>
            <th>L</th>
            <th>F</th>
            <th>A</th>
            <th>D</th>
            <th>Pts</th>
        </tr>";

foreach ($standings as $row) {
    echo "<tr>
            <td>{$row['position']}</td>
            <td>{$row['team_name']}</td>
            <td>{$row['played']}</td>
            <td>{$row['won']}</td>
            <td>{$row['drawn']}</td>
            <td>{$row['lost']}</td>
            <td>{$row['goals_for']}</td>
            <td>{$row['goals_against']}</td>
            <td>{$row['goal_difference']}</td>
            <td>{$row['points']}</td>
          </tr>";
}

echo "</table>";
?>
