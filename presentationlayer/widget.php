<?php
include('../datalayer/server.php');

try {
    // Fetch the competition ID and gender
    $sql_competition = "SELECT id, competition_name, gender FROM basketballcompetitions WHERE gender = 'female'";
    $stmt_competition = $pdo->prepare($sql_competition);
    $stmt_competition->execute();
    $competition = $stmt_competition->fetch(PDO::FETCH_ASSOC);

    if ($competition) {
        $competition_id = $competition['id'];
        $gender = 'female';
    } else {
        die('<h2>No Female Basketball Competition Found</h2>');
    }

    // Fetch the standings
    $sql = "
        SELECT
            ROW_NUMBER() OVER (ORDER BY win_percentage DESC, points_for DESC, points_against ASC, team_name ASC) AS position,
            team_name,
            games_played,
            wins,
            losses,
            points_for,
            points_against,
            win_percentage
        FROM basketball_standings
        WHERE competition_id = :competition_id
        ORDER BY win_percentage DESC, points_for DESC, points_against ASC, team_name ASC
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['competition_id' => $competition_id]);
    $standings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($standings);

} catch (PDOException $e) {
    echo 'Database error: ' . $e->getMessage();
}

