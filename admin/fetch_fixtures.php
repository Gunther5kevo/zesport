<?php
include('../datalayer/server.php');

// Get the competition ID from the request, defaulting to 1 if not provided
$competitionId = isset($_GET['competition_id']) ? (int)$_GET['competition_id'] : 1;

// Fetch competition name
$sql_competition = "SELECT competition_name FROM competitions WHERE id = :competition_id";
$stmt_competition = $pdo->prepare($sql_competition);
$stmt_competition->execute(['competition_id' => $competitionId]);
$competition = $stmt_competition->fetch(PDO::FETCH_ASSOC);

// Check if the competition ID is provided via POST
if (isset($_POST['competition_id'])) {
    $competition_id = $_POST['competition_id'];
    $sql = "SELECT id, match_date, home_team_id, away_team_id FROM football_matches WHERE competition_id = :competition_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['competition_id' => $competition_id]);

   
    $fixtures = $stmt->fetchAll(PDO::FETCH_ASSOC);

   
    $options = '<option value="">Select Fixture</option>';
    foreach ($fixtures as $fixture) {
        $stmt = $pdo->prepare("SELECT team_name FROM teams WHERE id = :team_id");
        $stmt->execute(['team_id' => $fixture['home_team_id']]);
        $home_team = $stmt->fetchColumn();

        // Fetch away team name
        $stmt = $pdo->prepare("SELECT team_name FROM teams WHERE id = :team_id");
        $stmt->execute(['team_id' => $fixture['away_team_id']]);
        $away_team = $stmt->fetchColumn();

        // Generate fixture option
        $options .= '<option value="' . $fixture['id'] . '">' . $fixture['match_date'] . ' - ' . $home_team . ' vs ' . $away_team . '</option>';
    }

    echo $options;
}else {

    echo '<option value="">Error: Competition ID not provided</option>';
}
?>
