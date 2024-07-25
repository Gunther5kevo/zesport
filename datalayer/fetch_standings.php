<?php
include('server.php');

try {
    // Determine the competition ID and season ID from the request or default to 1
    $competitionId = isset($_GET['competition_id']) ? (int)$_GET['competition_id'] : 1;
    $seasonId = isset($_GET['season_id']) ? (int)$_GET['season_id'] : 1;

    // Fetch competition details including gender
    $sql_competition = "SELECT id, competition_name, gender FROM competitions WHERE id = :competition_id";
    $stmt_competition = $pdo->prepare($sql_competition);
    $stmt_competition->execute(['competition_id' => $competitionId]);
    $competition = $stmt_competition->fetch(PDO::FETCH_ASSOC);

    if (!$competition) {
        die('<h2>Competition Not Found</h2>');
    }

    // Determine gender to fetch standings based on competition gender
    $gender = $competition['gender'];

    // Insert or update the calculated standings into the standings table
    $insert_query = "
    INSERT INTO standings (team_id, team_name, competition_id, season_id, played, won, drawn, lost, goals_for, goals_against, goal_difference, points)
    SELECT
        teams.id AS team_id,
        teams.team_name AS team_name,
        :competition_id AS competition_id,
        :season_id AS season_id,
        COUNT(fm.id) AS played,
        SUM(CASE WHEN (teams.id = fm.home_team_id AND fm.home_score > fm.away_score) OR (teams.id = fm.away_team_id AND fm.away_score > fm.home_score) THEN 1 ELSE 0 END) AS won,
        SUM(CASE WHEN fm.home_score = fm.away_score THEN 1 ELSE 0 END) AS drawn,
        SUM(CASE WHEN (teams.id = fm.home_team_id AND fm.home_score < fm.away_score) OR (teams.id = fm.away_team_id AND fm.away_score < fm.home_score) THEN 1 ELSE 0 END) AS lost,
        SUM(CASE WHEN teams.id = fm.home_team_id THEN fm.home_score ELSE fm.away_score END) AS goals_for,
        SUM(CASE WHEN teams.id = fm.home_team_id THEN fm.away_score ELSE fm.home_score END) AS goals_against,
        SUM(CASE WHEN teams.id = fm.home_team_id THEN fm.home_score ELSE fm.away_score END) - SUM(CASE WHEN teams.id = fm.home_team_id THEN fm.away_score ELSE fm.home_score END) AS goal_difference,
        SUM(CASE WHEN (teams.id = fm.home_team_id AND fm.home_score > fm.away_score) OR (teams.id = fm.away_team_id AND fm.away_score > fm.home_score) THEN 3 WHEN fm.home_score = fm.away_score THEN 1 ELSE 0 END) AS points
    FROM 
        teams
    LEFT JOIN 
        football_matches fm ON (teams.id = fm.home_team_id OR teams.id = fm.away_team_id)
    WHERE 
        teams.gender = :gender AND
        fm.competition_id = :competition_id AND
        fm.season_id = :season_id AND
        fm.home_score IS NOT NULL AND fm.away_score IS NOT NULL
    GROUP BY 
        teams.id, teams.team_name
    ON DUPLICATE KEY UPDATE
        played = VALUES(played),
        won = VALUES(won),
        drawn = VALUES(drawn),
        lost = VALUES(lost),
        goals_for = VALUES(goals_for),
        goals_against = VALUES(goals_against),
        goal_difference = VALUES(goal_difference),
        points = VALUES(points)
    ";

    $stmt_insert = $pdo->prepare($insert_query);
    $stmt_insert->execute(['competition_id' => $competitionId, 'season_id' => $seasonId, 'gender' => $gender]);

    // Fetch all teams and their standings
    $select_query = "
    SELECT 
        teams.team_name AS team_name,
        COALESCE(standings.played, 0) AS played,
        COALESCE(standings.won, 0) AS won,
        COALESCE(standings.drawn, 0) AS drawn,
        COALESCE(standings.lost, 0) AS lost,
        COALESCE(standings.goals_for, 0) AS goals_for,
        COALESCE(standings.goals_against, 0) AS goals_against,
        COALESCE(standings.goal_difference, 0) AS goal_difference,
        COALESCE(standings.points, 0) AS points
    FROM 
        teams
    LEFT JOIN 
        standings ON teams.id = standings.team_id AND standings.competition_id = :competition_id AND standings.season_id = :season_id
    WHERE 
        teams.gender = :gender
    ORDER BY 
        COALESCE(standings.points, 0) DESC, 
        COALESCE(standings.goal_difference, 0) DESC, 
        COALESCE(standings.goals_for, 0) DESC, 
        teams.team_name ASC
    ";

    $stmt_select = $pdo->prepare($select_query);
    $stmt_select->execute(['competition_id' => $competitionId, 'season_id' => $seasonId, 'gender' => $gender]);
    $standings = $stmt_select->fetchAll(PDO::FETCH_ASSOC);

    // Initialize variables for position calculation
    $currentRank = 1;

    // Iterate through standings to calculate positions
    foreach ($standings as &$team) {
        $team['position'] = $currentRank;
        $currentRank++;
    }

    // Display the standings
    echo "<h2>" . htmlspecialchars($competition['competition_name']) . " Standings </h2>";
    echo "<table class='table table-striped'>
            <thead>
                <tr>
                    <th>Position</th>
                    <th>Team</th>
                    <th>M</th>
                    <th>W</th>
                    <th>D</th>
                    <th>L</th>
                    <th>F</th>
                    <th>A</th>
                    <th>Dif.</th>
                    <th>Pts</th>
                </tr>
            </thead>
            <tbody>";

    foreach ($standings as $row) {
        echo "<tr>
                <td>" . htmlspecialchars($row['position']) . "</td>
                <td>" . htmlspecialchars($row['team_name']) . "</td>
                <td>" . htmlspecialchars($row['played']) . "</td>
                <td>" . htmlspecialchars($row['won']) . "</td>
                <td>" . htmlspecialchars($row['drawn']) . "</td>
                <td>" . htmlspecialchars($row['lost']) . "</td>
                <td>" . htmlspecialchars($row['goals_for']) . "</td>
                <td>" . htmlspecialchars($row['goals_against']) . "</td>
                <td>" . htmlspecialchars($row['goal_difference']) . "</td>
                <td>" . htmlspecialchars($row['points']) . "</td>
              </tr>";
    }

    echo "</tbody></table>";

} catch (PDOException $e) {
    die("Database error: " . htmlspecialchars($e->getMessage()));
}
