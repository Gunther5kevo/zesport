<!-- <?php
// session_start();
// include('db_connection.php'); // Your PDO connection setup

// // Fetch male and female teams
// $maleTeams = fetchTeamsByGender($pdo, 'male');
// $femaleTeams = fetchTeamsByGender($pdo, 'female');
?> -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Sports Teams</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Additional custom styles */
        .team-card {
            margin-bottom: 30px;
        }
        .team-card img {
            object-fit: cover;
            height: 200px;
            width: 100%;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">University Sports</a>
</nav>

<div class="container mt-4">
    <ul class="nav nav-tabs" id="teamTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="male-teams-tab" data-bs-toggle="tab" href="#male-teams" role="tab" aria-controls="male-teams" aria-selected="true">Male Teams</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="female-teams-tab" data-bs-toggle="tab" href="#female-teams" role="tab" aria-controls="female-teams" aria-selected="false">Female Teams</a>
        </li>
    </ul>
    <div class="tab-content" id="teamTabsContent">
        <div class="tab-pane fade show active" id="male-teams" role="tabpanel" aria-labelledby="male-teams-tab">
            <div class="row">
                <?php foreach ($maleTeams as $team): ?>
                    <div class="col-md-4">
                        <div class="card team-card">
                            <img src="<?php echo htmlspecialchars($team['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($team['team_name']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($team['team_name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($team['description']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="tab-pane fade" id="female-teams" role="tabpanel" aria-labelledby="female-teams-tab">
            <div class="row">
                <?php foreach ($femaleTeams as $team): ?>
                    <div class="col-md-4">
                        <div class="card team-card">
                            <img src="<?php echo htmlspecialchars($team['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($team['team_name']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($team['team_name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($team['description']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
