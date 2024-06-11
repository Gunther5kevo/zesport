<?php include('includes/header.php'); ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <?= alertMessage(); ?>
            <h2>Update Football Scores</h2>
            <form method="post" action="admin_functions.php">
                <div class="mb-3">
                    <label for="competition_id" class="form-label">Select Competition:</label>
                    <select id="competition_id" name="competition_id" class="form-select" required>
                        <option value="">Select Competition</option>
                        <?php
                        // Fetch competitions from the database
                        $sql = "SELECT id, competition_name FROM competitions";
                        $stmt = $pdo->query($sql);
                        $competitions = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        // Display competitions as dropdown options
                        foreach ($competitions as $competition) {
                            echo '<option value="' . htmlspecialchars($competition['id']) . '">';
                            echo htmlspecialchars($competition['competition_name']) . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="fixture_id" class="form-label">Select Fixture:</label>
                    <select id="fixture_id" name="fixture_id" class="form-select" required>
                        <option value="">Select Fixture</option>
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

                <button type="submit" name="update_football_scores" class="btn btn-primary">Update Scores</button>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
   $(document).ready(function() {
    $('#competition_id').change(function() {
        var competitionId = $(this).val();
        console.log('Selected competition ID:', competitionId); // Debug statement
        // Send an AJAX request to fetch fixtures for the selected competition
        $.ajax({
            type: 'POST',
            url: 'fetch_fixtures.php', // Assuming you have a PHP file to handle fetching fixtures
            data: { competition_id: competitionId },
            success: function(response) {
                // Clear existing options
                $('#fixture_id').html('<option value="">Select Fixture</option>');
                // Populate the fixture dropdown with fetched fixture data
                $('#fixture_id').append(response);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching fixtures:', error);
            }
        });
    });
});

</script>
