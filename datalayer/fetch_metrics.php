<?php
include('server.php'); // Include your database connection script

header('Content-Type: application/json');

try {
    // Total Matches
    $stmt = $pdo->query("SELECT COUNT(*) FROM football_matches");
    $totalMatches = $stmt->fetchColumn();

    // Total Teams
    $stmt = $pdo->query("SELECT COUNT(*) FROM teams");
    $totalTeams = $stmt->fetchColumn();

    // Upcoming Fixtures
    $stmt = $pdo->query("SELECT COUNT(*) FROM football_matches WHERE match_date > NOW()");
    $upcomingFixtures = $stmt->fetchColumn();

    // Latest Matches
    $stmt = $pdo->query("SELECT match_date, home_team_id, away_team_id, home_score, away_score FROM football_matches ORDER BY match_date DESC LIMIT 5");
    $latestMatches = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Upcoming Matches (detailed)
    $stmt = $pdo->query("SELECT match_date, home_team_id, away_team_id FROM football_matches WHERE match_date > NOW() ORDER BY match_date ASC LIMIT 5");
    $upcomingMatches = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare JSON response
    $response = [
        'totalMatches' => $totalMatches,
        'totalTeams' => $totalTeams,
        'upcomingFixtures' => $upcomingFixtures,
        'latestMatches' => $latestMatches,
        'upcomingMatches' => $upcomingMatches
    ];

    echo json_encode($response);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}

