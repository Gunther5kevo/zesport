
<?php

include('includes/header.php')
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
        <?= alertMessage();?>
            <h2>Update Rugby Scores</h2>
            <form method="post" action="admin_functions.php">
                <div class="mb-3">
                    <label for="fixture_id" class="form-label">Select Fixture:</label>
                    <select id="fixture_id" name="fixture_id" class="form-select" required>
                        <option value="">Select Fixture</option>
                        <?php
                        // Fetch fixtures from the database
                        $sql = "SELECT id, match_date, home_team_id, away_team_id FROM rugby_matches";
                        $stmt = $pdo->query($sql);
                        $fixtures = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        // Get today's date
                        $currentDate = date('Y-m-d');

                        // Display fixtures as dropdown options
                        foreach ($fixtures as $fixture) {
                            // Check if the match date is today
                            if ($fixture['match_date'] == $currentDate) {
                                // If the match date is today, enable the option
                                echo '<option value="' . htmlspecialchars($fixture['id']) . '">';
                                // Display the fixture details
                                echo htmlspecialchars($fixture['match_date'] . ' - ' . $fixture['home_team_id'] . ' vs ' . $fixture['away_team_id']) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="home_score" class="form-label">Home Team Score:</label>
                    <input type="number" id="home_score" name="home_score" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="away_score" class="form-label">Away Team Score:</label>
                    <input type="number" id="away_score" name="away_score" class="form-control" required>
                </div>

                <button type="submit" name="update_rugby_scores" class="btn btn-primary">Update Scores</button>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php');?>

