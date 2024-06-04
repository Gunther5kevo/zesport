<?php

include('includes/header.php')
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
        <?= alertMessage();?>
        <p class="text-sm mb-0 text-capitalize">Football Teams</p>
        <form method="POST" action="admin_functions.php" class="row g-3">
            <div class="col-md-6">
                <label for="team_name" class="form-label">Team Name:</label>
                <input type="text" id="team_name" name="team_name" class="form-control" required>
            </div>
            
            <div class="col-md-6">
                <label for="gender" class="form-label">Gender:</label>
                <select id="gender" name="gender" class="form-control" required>
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            
            <div class="col-12">
                <button type="submit" name="create_football_team" class="btn btn-primary">Create Team</button>
            </div>
        </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
        <?= alertMessage();?>
        <p class="text-sm mb-0 text-capitalize">Rugby Teams</p>
        <form method="POST" action="admin_functions.php" class="row g-3">
            <div class="col-md-6">
                <label for="team_name" class="form-label">Team Name:</label>
                <input type="text" id="team_name" name="team_name" class="form-control" required>
            </div>
            
            <div class="col-12">
                <button type="submit" name="create_rugby_team" class="btn btn-primary">Create Team</button>
            </div>
        </form>
        </div>
    </div>
</div> 

<div class="row">
    <div class="col-md-12">
        <div class="card">
        <?= alertMessage();?>
        <p class="text-sm mb-0 text-capitalize">Basketball Teams</p>
        <form method="POST" action="admin_functions.php" class="row g-3">
            
            <div class="col-md-6">
                <label for="team_name" class="form-label">Team Name:</label>
                <input type="text" id="team_name" name="team_name" class="form-control" required>
            </div>
            
            <div class="col-12">
                <button type="submit" name="create_basketball_team" class="btn btn-primary">Create Team</button>
            </div>
        </form>
        </div>
    </div>
</div> 

<?php include('includes/footer.php'); ?>