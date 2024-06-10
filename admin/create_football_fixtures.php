<?php
include('includes/header.php');


// Fetch competitions from the database
$sql_competitions = "SELECT id, competition_name FROM competitions ORDER BY competition_name";
$stmt_competitions = $pdo->query($sql_competitions);
$competitions = $stmt_competitions->fetchAll(PDO::FETCH_ASSOC);

// Fetch teams based on the default gender selection for initial page load
$gender = 'Male';
$sql_teams = "SELECT id, team_name FROM teams WHERE gender = :gender ORDER BY team_name";
$stmt_teams = $pdo->prepare($sql_teams); // Prepare the SQL statement
$stmt_teams->execute(['gender' => $gender]); // Execute with parameter
$teams = $stmt_teams->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <?= alertMessage(); ?>
            <h4>Create New Football Fixture</h4>
            <form method="post" action="admin_functions.php">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="gender">Gender:</label>
                        <select id="gender" name="gender" class="form-control">
                            <option value="Male" <?= $gender === 'Male' ? 'selected' : '' ?>>Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="competition">Competition:</label>
                        <select id="competition" name="competition" class="form-control" required>
                            <option value="" selected>No competition</option>
                            <?php foreach ($competitions as $competition): ?>
                                <option value="<?= htmlspecialchars($competition['id']) ?>"><?= htmlspecialchars($competition['competition_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="match_date">Match Date:</label>
                        <input type="date" id="match_date" name="match_date" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="match_time">Match Time:</label>
                        <input type="time" id="match_time" name="match_time" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="home_team">Home Team:</label>
                        <select id="home_team" name="home_team" class="form-control">
                            <option value="" disabled selected>Select a team</option>
                            <?php foreach ($teams as $team): ?>
                                <option value="<?= htmlspecialchars($team['id']) ?>"><?= htmlspecialchars($team['team_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="away_team">Away Team:</label>
                        <select id="away_team" name="away_team" class="form-control">
                            <option value="" disabled selected>Select a team</option>
                            <?php foreach ($teams as $team): ?>
                                <option value="<?= htmlspecialchars($team['id']) ?>"><?= htmlspecialchars($team['team_name']) ?></option>
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
                <button type="submit" class="btn btn-primary" name="create_fixture">Create Fixture</button>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>

<!-- Include jQuery for simplicity -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    function getTeams() {
        var gender = $('#gender').val();
        $.ajax({
            url: '../datalayer/fetch_teams.php',
            method: 'GET',
            data: { gender: gender },
            dataType: 'json',
            success: function(teams) {
                var homeTeamSelect = $('#home_team');
                var awayTeamSelect = $('#away_team');
                homeTeamSelect.empty().append('<option value="" disabled selected>Select a team</option>');
                awayTeamSelect.empty().append('<option value="" disabled selected>Select a team</option>');
                $.each(teams, function(index, team) {
                    homeTeamSelect.append('<option value="' + team.id + '">' + team.team_name + '</option>');
                    awayTeamSelect.append('<option value="' + team.id + '">' + team.team_name + '</option>');
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error fetching teams: ", textStatus, errorThrown);
            }
        });
    }

    $('#gender').change(getTeams);
    getTeams(); // Initial call to load teams based on the default gender selection
});
</script>
