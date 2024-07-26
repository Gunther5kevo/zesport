<?php
include('includes/header.php');

try {
    // Fetch seasons from the database
    $sql_seasons = "SELECT id, season FROM seasons ORDER BY season DESC";
    $stmt_seasons = $pdo->query($sql_seasons);
    $seasons = $stmt_seasons->fetchAll(PDO::FETCH_ASSOC);

    // Fetch teams based on the default gender selection for initial page load
    $gender = 'Male'; // Replace with your default gender selection logic
    $sql_teams = "SELECT id, team_name FROM teams WHERE gender = :gender ORDER BY team_name";
    $stmt_teams = $pdo->prepare($sql_teams);
    $stmt_teams->execute(['gender' => $gender]);
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
                        <label for="season">Season:</label>
                        <select id="season" name="season" class="form-control" required>
                            <option value="" selected>No season</option>
                            <?php foreach ($seasons as $season): ?>
                                <option value="<?= htmlspecialchars($season['id']) ?>"><?= htmlspecialchars($season['season']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="competition">Competition:</label>
                        <select id="competition" name="competition" class="form-control" required>
                            <option value="" selected>No competition</option>
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
    function getCompetitions() {
        var seasonId = $('#season').val();
        var gender = $('#gender').val();
        $.ajax({
            url: '../datalayer/fetch_competitions.php', // Ensure this path is correct
            method: 'GET',
            data: { season: seasonId, gender: gender },
            dataType: 'json',
            success: function(response) {
                var competitionSelect = $('#competition');
                competitionSelect.empty().append('<option value="" selected>No competition</option>');
                if (response.error) {
                    console.error('Error:', response.error);
                } else {
                    $.each(response, function(index, competition) {
                        competitionSelect.append('<option value="' + competition.id + '">' + competition.competition_name + '</option>');
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error fetching competitions:", textStatus, errorThrown);
            }
        });
    }

    function getTeams() {
        var gender = $('#gender').val();
        $.ajax({
            url: '../datalayer/fetch_teams.php', // Ensure this path is correct
            method: 'GET',
            data: { gender: gender },
            dataType: 'json',
            success: function(response) {
                var homeTeamSelect = $('#home_team');
                var awayTeamSelect = $('#away_team');
                homeTeamSelect.empty().append('<option value="" disabled selected>Select a team</option>');
                awayTeamSelect.empty().append('<option value="" disabled selected>Select a team</option>');
                if (response.error) {
                    console.error('Error:', response.error);
                } else {
                    $.each(response, function(index, team) {
                        homeTeamSelect.append('<option value="' + team.id + '">' + team.team_name + '</option>');
                        awayTeamSelect.append('<option value="' + team.id + '">' + team.team_name + '</option>');
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error fetching teams:", textStatus, errorThrown);
            }
        });
    }

    function updateTeamOptions() {
        var homeTeamId = $('#home_team').val();
        var awayTeamId = $('#away_team').val();
        var homeTeamSelect = $('#home_team');
        var awayTeamSelect = $('#away_team');

        homeTeamSelect.find('option').show();
        awayTeamSelect.find('option').show();

        if (homeTeamId) {
            awayTeamSelect.find('option[value="' + homeTeamId + '"]').hide();
        }

        if (awayTeamId) {
            homeTeamSelect.find('option[value="' + awayTeamId + '"]').hide();
        }
    }

    $('#season').change(getCompetitions);
    $('#gender').change(function() {
        getTeams();
        getCompetitions();
    });
    $('#home_team').change(updateTeamOptions);
    $('#away_team').change(updateTeamOptions);

    getTeams(); // Initial call to load teams based on the default gender selection
    getCompetitions(); // Initial call to load competitions based on the default gender and season selection
});
</script>

<?php
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
