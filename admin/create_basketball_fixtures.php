<?php


include('./admin_functions.php');
include('includes/header.php')
?>

<?php
// Fetch teams and competitions from the database
try {
    
    // Fetch basketball teams
    $sqlTeams = "SELECT id, team_name FROM basketball_teams ORDER BY team_name";
    $stmtTeams = $pdo->query($sqlTeams);
    $teams = $stmtTeams->fetchAll(PDO::FETCH_ASSOC);

    // Fetch competitions
    $sqlCompetitions = "SELECT id, competition_name FROM competitions ORDER BY competition_name";
    $stmtCompetitions = $pdo->query($sqlCompetitions);
    $competitions = $stmtCompetitions->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo 'Error fetching data: ' . $e->getMessage();
    exit;
}
?>
<div class="row">
        <div class="col-md-12">
            <div class="card">
                <h2>Create New Basketball Fixture</h2>
                <form method="post" action="admin_functions.php">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="match_date">Match Date:</label>
                            <input type="date" id="match_date" name="match_date" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="home_team">Home Team:</label>
                            <select id="home_team" name="home_team" class="form-control" required>
                                <option value="" disabled selected>Select a team</option>
                                <?php foreach ($teams as $team): ?>
                                    <option value="<?= htmlspecialchars($team['id']) ?>"><?= htmlspecialchars($team['team_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="away_team">Away Team:</label>
                            <select id="away_team" name="away_team" class="form-control" required>
                                <option value="" disabled selected>Select a team</option>
                                <?php foreach ($teams as $team): ?>
                                    <option value="<?= htmlspecialchars($team['id']) ?>"><?= htmlspecialchars($team['team_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="competition">Competition:</label>
                            <select id="competition" name="competition" class="form-control" required>
                                <option value="" disabled selected>Select a competition</option>
                                <?php foreach ($competitions as $competition): ?>
                                    <option value="<?= htmlspecialchars($competition['id']) ?>"><?= htmlspecialchars($competition['competition_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="venue">Venue:</label>
                            <input type="text" id="venue" name="venue" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="referee">Referee:</label>
                            <input type="text" id="referee" name="referee" class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" name="create_basketball_fixture" class="btn btn-primary">Create Fixture</button>
                </form>
            </div>
        </div>
    </div>
<?php include('includes/footer.php');?>