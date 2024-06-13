<?php
include('../datalayer/server.php');

// Fetch competition name and gender (female only)
$sql_competition = "SELECT id, competition_name, gender FROM competitions WHERE gender = 'female'";
$stmt_competition = $pdo->prepare($sql_competition);
$stmt_competition->execute();
$competition = $stmt_competition->fetch(PDO::FETCH_ASSOC);

if (!$competition) {
    die('<h2>No Female Competition Found</h2>');
}

$competitionId = $competition['id'];

// Clear the standings table
$truncate_query = "TRUNCATE TABLE standings";
try {
    $pdo->exec($truncate_query);
} catch (PDOException $e) {
    die("Error truncating standings table: " . $e->getMessage());
}

// Insert the calculated standings into the standings table
$insert_query = "
INSERT INTO standings (team_id, competition_id, played, won, drawn, lost, goals_for, goals_against, goal_difference, points)
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
        fm.match_date <= CURDATE()

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
        fm.match_date <= CURDATE()
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

// Fetch the standings
$select_query = "
SELECT 
    teams.team_name,
    standings.played,
    standings.won,
    standings.drawn,
    standings.lost,
    standings.goals_for,
    standings.goals_against,
    standings.goal_difference,
    standings.points
FROM 
    standings
INNER JOIN 
    teams ON standings.team_id = teams.id
WHERE
    standings.competition_id = :competition_id
ORDER BY 
    standings.points DESC, 
    standings.goal_difference DESC, 
    standings.goals_for DESC
";

try {
    $stmt = $pdo->prepare($select_query);
    $stmt->execute(['competition_id' => $competitionId]);
    $standings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Initialize variables for position calculation
    $currentPosition = 1;
    $currentRank = 1;
    $previousStats = null;

    // Iterate through standings to calculate positions
    foreach ($standings as &$team) {
        // Check if current team has the same stats as previous team
        if ($previousStats !== null &&
            $team['points'] == $previousStats['points'] &&
            $team['goal_difference'] == $previousStats['goal_difference'] &&
            $team['goals_for'] == $previousStats['goals_for']) {
            // Assign the same rank as previous team
            $team['position'] = $currentPosition;
        } else {
            // Assign current rank and position
            $team['position'] = $currentRank;
            $currentPosition = $currentRank;
        }

        // Update current rank for next iteration
        $currentRank++;
        $previousStats = $team; // Update previous stats to current team
    }

} catch (PDOException $e) {
    die("Error fetching standings: " . $e->getMessage());
}

// Display the standings
echo "<h2>{$competition['competition_name']}</h2>";
echo "<table class='table table-striped'>
        <thead>
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
            </tr>
        </thead>
        <tbody>";

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

echo "</tbody></table>";
?>
