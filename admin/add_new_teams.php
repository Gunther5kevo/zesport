<?php
include('./admin_functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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


</body>
</html>