<?php
include('../datalayer/server.php');

try {
    // Check if a competition ID and season ID are provided
    $competitionId = isset($_GET['competition_id']) ? (int)$_GET['competition_id'] : 0;
    $seasonId = isset($_GET['season_id']) ? (int)$_GET['season_id'] : 0;

    if ($competitionId === 0 || $seasonId === 0) {
        die('<h2>No valid competition or season ID provided</h2>');
    }

    // Query to find the basketball competition details
    $sql_competition = "SELECT id, competition_name, gender FROM basketballcompetitions WHERE id = :competition_id";
    $stmt_competition = $pdo->prepare($sql_competition);
    $stmt_competition->execute(['competition_id' => $competitionId]);
    $competition = $stmt_competition->fetch(PDO::FETCH_ASSOC);

    if (!$competition) {
        die('<h2>Competition not found</h2>');
    }

    $gender = $competition['gender'];

    // Clear the standings table for the specific competition and season
    $pdo->prepare("DELETE FROM basketball_standings WHERE competition_id = :competition_id AND season_id = :season_id")->execute(['competition_id' => $competitionId, 'season_id' => $seasonId]);

    // Insert the calculated standings into the standings table
    $query = "
    INSERT INTO basketball_standings (competition_id, season_id, team_id, team_name, games_played, wins, losses, points_for, points_against, win_percentage)
    SELECT
        :competition_id AS competition_id,
        :season_id AS season_id,
        t.id AS team_id,
        t.team_name AS team_name,
        COALESCE(SUM(games_played), 0) AS games_played,
        COALESCE(SUM(wins), 0) AS wins,
        COALESCE(SUM(losses), 0) AS losses,
        COALESCE(SUM(points_for), 0) AS points_for,
        COALESCE(SUM(points_against), 0) AS points_against,
        COALESCE(ROUND(SUM(wins) / NULLIF(SUM(games_played), 0), 3), 0) AS win_percentage
    FROM 
        basketball_teams t
    LEFT JOIN (
        SELECT 
            home.id AS team_id,
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
            fm.match_date <= CURDATE() AND fm.competition_id = :competition_id AND fm.season_id = :season_id AND home.gender = :gender

        UNION ALL

        SELECT 
            away.id AS team_id,
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
            fm.match_date <= CURDATE() AND fm.competition_id = :competition_id AND fm.season_id = :season_id AND away.gender = :gender
    ) AS match_results ON t.id = match_results.team_id
    WHERE t.gender = :gender
    GROUP BY t.id, t.team_name
    ORDER BY win_percentage DESC, points_for DESC, points_against ASC, team_name ASC
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute(['competition_id' => $competitionId, 'season_id' => $seasonId, 'gender' => $gender]);

    // Fetch and display the standings
    $result = $pdo->prepare("
        SELECT 
            team_id, team_name, games_played, wins, losses, points_for, points_against, win_percentage,
            @curRank := IF(@prevPercentage = win_percentage AND @prevPointsFor = points_for AND @prevPointsAgainst = points_against, @curRank, @curRank + 1) AS position,
            @prevPercentage := win_percentage,
            @prevPointsFor := points_for,
            @prevPointsAgainst := points_against
        FROM 
            basketball_standings, 
            (SELECT @curRank := 0, @prevPercentage := NULL, @prevPointsFor := NULL, @prevPointsAgainst := NULL) AS vars
        WHERE 
            competition_id = :competition_id AND season_id = :season_id
        ORDER BY 
            win_percentage DESC, points_for DESC, points_against ASC, team_name ASC
    ");
    $result->execute(['competition_id' => $competitionId, 'season_id' => $seasonId]);

    echo "<h2>Basketball Standings for " . htmlspecialchars($competition['competition_name']) . "</h2>";
    echo "<table>
            <tr>
                <th>Position</th>
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
                <td>" . htmlspecialchars($row['position']) . "</td>
                <td>" . htmlspecialchars($row['team_name']) . "</td>
                <td>" . htmlspecialchars($row['games_played']) . "</td>
                <td>" . htmlspecialchars($row['wins']) . "</td>
                <td>" . htmlspecialchars($row['losses']) . "</td>
                <td>" . htmlspecialchars($row['points_for']) . "</td>
                <td>" . htmlspecialchars($row['points_against']) . "</td>
                <td>" . number_format($row['win_percentage'], 3) . "</td>
              </tr>";
    }

    echo "</table>";

} catch (PDOException $e) {
    // Display a user-friendly message and log the error details
    echo '<h2>An error occurred while fetching the standings. Please try again later.</h2>';
    error_log('Database error: ' . $e->getMessage());
}

