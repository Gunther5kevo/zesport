<?php


include('./admin_functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<h2>Welcome, Admin!</h2>
<p>You are logged in to the admin dashboard.</p>

<!-- Video Upload Form -->
<div class="video-upload">
    <h3>Upload New Video</h3>
    <form method="POST" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br><br>
        
        <label for="video">Choose Video File:</label>
        <input type="file" id="video" name="video" accept="video/*" required><br><br>
        
        <label for="category">Category:</label>
        <input type="text" id="category" name="category" required><br><br> <!-- Or replace input type with select for predefined categories -->
        
        <button type="submit" name="submit">Upload</button>
    </form>
</div>


<!-- Video Deletion Form -->
<h3>Delete Video</h3>
<form method="POST">
    <label for="videoId">Select Video to Delete:</label>
    <select id="videoId" name="videoId" required>
        <!-- Populate this select dropdown with options from database -->
        <!-- Example: <option value="1">Video Title 1</option> -->
    </select>
    <button type="submit" name="delete">Delete</button>
</form>

    <section class= "fixtures">
    <div class="football-section">
    <h2>Create New  Football Fixture</h2>
    <form method="post" action="admin_functions.php">
        <label for="match_date">Match Date:</label>
        <input type="date" id="match_date" name="match_date" required><br>

        <label for="home_team">Home Team:</label>
        <select id="home_team" name="home_team" required>
            <?php
            // Fetch teams from database
            $sql = "SELECT id, team_name FROM teams ORDER BY team_name";
            $stmt = $pdo->query($sql);
            $teams = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Display teams in dropdown options
            foreach ($teams as $team) {
                echo '<option value="' . htmlspecialchars($team['id']) . '">' . htmlspecialchars($team['team_name']) . '</option>';
            }
            ?>
        </select><br>

        <label for="away_team">Away Team:</label>
        <select id="away_team" name="away_team" required>
            <?php
            // Display teams in dropdown options
            foreach ($teams as $team) {
                echo '<option value="' . htmlspecialchars($team['id']) . '">' . htmlspecialchars($team['team_name']) . '</option>';
            }
            ?>
        </select><br>

        <label for="competition">Competition:</label>
        <select id="competition" name="competition" required>
            <?php
            // Fetch competitions from database
            $sql = "SELECT id, competition_name FROM competitions ORDER BY competition_name";
            $stmt = $pdo->query($sql);
            $competitions = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Display competitions in dropdown options
            foreach ($competitions as $competition) {
                echo '<option value="' . htmlspecialchars($competition['id']) . '">' . htmlspecialchars($competition['competition_name']) . '</option>';
            }
            ?>
        </select><br>

        <label for="venue">Venue:</label>
        <input type="text" id="venue" name="venue" required><br>

        <label for="referee">Referee:</label>
        <input type="text" id="referee" name="referee" required><br>

        <button type="submit" name="create_fixture">Create Fixture</button>
    </form>
    </div>
    
    <div class="basketball-section">
    <h2>Create New  Basketball  Fixture</h2>
    <form method="post" action="admin_functions.php">
        <label for="match_date">Match Date:</label>
        <input type="date" id="match_date" name="match_date" required><br>

        <label for="home_team">Home Team:</label>
        <select id="home_team" name="home_team" required>
            <?php
            // Fetch teams from database
            $sql = "SELECT id, team_name FROM basketball_teams ORDER BY team_name";
            $stmt = $pdo->query($sql);
            $teams = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Display teams in dropdown options
            foreach ($teams as $team) {
                echo '<option value="' . htmlspecialchars($team['id']) . '">' . htmlspecialchars($team['team_name']) . '</option>';
            }
            ?>
        </select><br>

        <label for="away_team">Away Team:</label>
        <select id="away_team" name="away_team" required>
            <?php
            // Display teams in dropdown options
            foreach ($teams as $team) {
                echo '<option value="' . htmlspecialchars($team['id']) . '">' . htmlspecialchars($team['team_name']) . '</option>';
            }
            ?>
        </select><br>

        <label for="competition">Competition:</label>
        <select id="competition" name="competition" required>
            <?php
            // Fetch competitions from database
            $sql = "SELECT id, competition_name FROM competitions ORDER BY competition_name";
            $stmt = $pdo->query($sql);
            $competitions = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Display competitions in dropdown options
            foreach ($competitions as $competition) {
                echo '<option value="' . htmlspecialchars($competition['id']) . '">' . htmlspecialchars($competition['competition_name']) . '</option>';
            }
            ?>
        </select><br>

        <label for="venue">Venue:</label>
        <input type="text" id="venue" name="venue" required><br>

        <label for="referee">Referee:</label>
        <input type="text" id="referee" name="referee" required><br>

        <button type="submit" name="create_basketball_fixture">Create Fixture</button>
    </form>
    </div>


    <div class="rugby-section">
    <h2>Create New  Rugby  Fixture</h2>
    <form method="post" action="admin_functions.php">
        <label for="match_date">Match Date:</label>
        <input type="date" id="match_date" name="match_date" required><br>

        <label for="home_team">Home Team:</label>
        <select id="home_team" name="home_team" required>
            <?php
            // Fetch teams from database
            $sql = "SELECT id, team_name FROM rugby_teams ORDER BY team_name";
            $stmt = $pdo->query($sql);
            $teams = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Display teams in dropdown options
            foreach ($teams as $team) {
                echo '<option value="' . htmlspecialchars($team['id']) . '">' . htmlspecialchars($team['team_name']) . '</option>';
            }
            ?>
        </select><br>

        <label for="away_team">Away Team:</label>
        <select id="away_team" name="away_team" required>
            <?php
            // Display teams in dropdown options
            foreach ($teams as $team) {
                echo '<option value="' . htmlspecialchars($team['id']) . '">' . htmlspecialchars($team['team_name']) . '</option>';
            }
            ?>
        </select><br>

        <label for="competition">Competition:</label>
        <select id="competition" name="competition" required>
            <?php
            // Fetch competitions from database
            $sql = "SELECT id, competition_name FROM competitions ORDER BY competition_name";
            $stmt = $pdo->query($sql);
            $competitions = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Display competitions in dropdown options
            foreach ($competitions as $competition) {
                echo '<option value="' . htmlspecialchars($competition['id']) . '">' . htmlspecialchars($competition['competition_name']) . '</option>';
            }
            ?>
        </select><br>

        <label for="venue">Venue:</label>
        <input type="text" id="venue" name="venue" required><br>

        <label for="referee">Referee:</label>
        <input type="text" id="referee" name="referee" required><br>

        <button type="submit" name="create_rugby_fixture">Create Fixture</button>
    </form>
    </div>

    </section>
    <section class="score">
        
        <div class="football_score">
        <h2>Update football scores </h2>
        <form method="post" action="admin_functions.php">
        <label for="fixture_id">Select Fixture:</label>
        <select id="fixture_id" name="fixture_id" required>
            <option value="">Select Fixture</option>
            <?php
            // Fetch fixtures from the database
            $sql = "SELECT id, match_date, home_team_id, away_team_id FROM football_matches";
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
        </select><br>

        <label for="home_score">Home Team Score:</label>
        <input type="number" id="home_score" name="home_score" required><br>

        <label for="away_score">Away Team Score:</label>
        <input type="number" id="away_score" name="away_score" required><br>

        <button type="submit" name="update_football_scores">Update Scores</button>
        </form>
        </div>

        <div class="basketball_score">
        <h2> Update basketball scores </h2>
        <form method="post" action="admin_functions.php">
        <label for="fixture_id">Select Fixture:</label>
        <select id="fixture_id" name="fixture_id" required>
            <option value="">Select Fixture</option>
            <?php
            // Fetch fixtures from the database
            $sql = "SELECT id, match_date, home_team_id, away_team_id FROM basketball_matches";
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
        </select><br>

        <label for="home_score">Home Team Score:</label>
        <input type="number" id="home_score" name="home_score" required><br>

        <label for="away_score">Away Team Score:</label>
        <input type="number" id="away_score" name="away_score" required><br>

        <button type="submit" name="update_basketball_scores">Update Scores</button>
        </form>
        </div>
        
        <div class="basketball_score">
        <h2> Update rugby scores </h2>
        <form method="post" action="admin_functions.php">
        <label for="fixture_id">Select Fixture:</label>
        <select id="fixture_id" name="fixture_id" required>
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
        </select><br>

        <label for="home_score">Home Team Score:</label>
        <input type="number" id="home_score" name="home_score" required><br>

        <label for="away_score">Away Team Score:</label>
        <input type="number" id="away_score" name="away_score" required><br>

        <button type="submit" name="update_rugby_scores">Update Scores</button>
        </form>
        </div>

    </section>

    <section class="blog">
        <div class="blog-section">
        <h2>Create New Blog Post</h2>
            <form method="post" action="admin_post.php" enctype="multipart/form-data">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required><br>

                <label for="author">Author:</label>
                <input type="text" id="author" name="author" required><br>

                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required><br>

                <label for="content">Content:</label>
                <textarea id="content" name="content" required></textarea><br>

                <label for="image">Image:</label>
                <input type="file" id="image" name="image" required><br>

                <label for="link">Link:</label>
                <input type="text" id="link" name="link" required><br>

                <button type="submit" name="create_post">Create Post</button>
            </form>
    </section>
    
    <section class="teams">
        <div class="basketball-teams">
        <h2>Add New Basketball Team</h2>
            <form method="post" action="admin_functions.php">
                <label for="team_name">Team Name:</label>
                <input type="text" id="team_name" name="team_name" required><br>
                <button type="submit" name="add_basketball_team">Add Team</button>
            </form>
        </div>
        
        <div class="football-teams">
        <h2>Add New Football Team</h2>
            <form method="post" action="admin_functions.php">
                <label for="team_name">Team Name:</label>
                <input type="text" id="team_name" name="team_name" required><br>
                <button type="submit" name="add_football_team">Add Team</button>
            </form>
        </div>    
        
        <div class="rugby-teams">
        <h2>Add New Rugby Team</h2>
            <form method="post" action="admin_functions.php">
                <label for="team_name">Team Name:</label>
                <input type="text" id="team_name" name="team_name" required><br>
                <button type="submit" name="add_rugby_team">Add Team</button>
            </form>
        </div>    






<a href="admin_logout.php">Logout</a>

</body>
</html>
