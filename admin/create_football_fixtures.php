<?php



include('includes/header.php')


?>

<?php
// Assume you have already established a database connection

// Fetch teams from the database
$sql_teams = "SELECT id, team_name FROM teams ORDER BY team_name";
$stmt_teams = $pdo->query($sql_teams);
$teams = $stmt_teams->fetchAll(PDO::FETCH_ASSOC);

// Fetch competitions from the database
$sql_competitions = "SELECT id, competition_name FROM competitions ORDER BY competition_name";
$stmt_competitions = $pdo->query($sql_competitions);
$competitions = $stmt_competitions->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
        <?= alertMessage();?>
            <h4>Create New Football Fixture</h4>
            <form method="post" action="admin_functions.php">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="match_date">Match Date:</label>
                        <input type="date" id="match_date" name="match_date" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="home_team">Home Team:</label>
                        <select id="home_team" name="home_team" class="form-control" >
                            <option value="" disabled selected>Select a team</option>
                            <?php foreach ($teams as $team): ?>
                                <option value="<?= htmlspecialchars($team['id']) ?>"><?= htmlspecialchars($team['team_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="away_team">Away Team:</label>
                        <select id="away_team" name="away_team" class="form-control" >
                            <option value="" disabled selected>Select a team</option>
                            <?php foreach ($teams as $team): ?>
                                <option value="<?= htmlspecialchars($team['id']) ?>"><?= htmlspecialchars($team['team_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="competition">Competition:</label>
                        <select id="competition" name="competition" class="form-control">
                            <option value="" disabled selected>Select a competition</option>
                            <?php foreach ($competitions as $competition): ?>
                                <option value="<?= htmlspecialchars($competition['id']) ?>"><?= htmlspecialchars($competition['competition_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="venue">Venue:</label>
                        <input type="text" id="venue" name="venue" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="referee">Referee:</label>
                        <input type="text" id="referee" name="referee" class="form-control">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Create Fixture</button>
            </form>
        </div>
    </div>
</div>

 

 

  
    
<?php include('includes/footer.php'); ?>