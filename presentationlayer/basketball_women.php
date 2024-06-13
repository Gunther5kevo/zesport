<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basketball Fixtures - ZeSport</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/football.css">
    <style>
        .custom-navbar {
            background-color: #1C1D3C !important;
            font-family: "Times New Roman", Times, serif;
            font-size: 18px;
            line-height: 1.7em;
            color: #333;
            font-weight: normal;
            font-style: normal;
            padding-right: 20px;
        }
        .custom-navbar .navbar-nav .nav-link {
            color: whitesmoke !important;
            text-transform: uppercase;
            margin-right: 15px;
        }
        .custom-navbar .navbar-brand {
            margin-left: 70px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark custom-navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="assets/img/zetechlogo.png" alt="Zetech University" style="max-width: 100px; height: auto;" class="d-inline-block align-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="basketball_women.php?action=standings">Standings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="basketball_women.php?action=fixtures">Fixtures</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="basketball_women.php?action=results">Results</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="basketball_women.php?action=news">News</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <?php
        include('../datalayer/server.php');
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
            if ($action === 'standings' || $action === 'fixtures' || $action === 'results') {
                ?>
                <h2>Select Competition:</h2>
                <form id="competitionForm">
                    <div class="mb-3">
                        <label for="competition" class="form-label">Competition:</label>
                        <select class="form-select" id="competition" name="competition_id">
                            <?php 
                            // Fetch competitions based on gender
                            $gender = 'female';
                            $sql = "SELECT id, competition_name FROM basketballcompetitions WHERE gender = :gender";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute(['gender' => $gender]);
                            $competitions = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            
                            foreach ($competitions as $competition) {
                                echo '<option value="' . $competition['id'] . '">' . $competition['competition_name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </form>

                <div id="content"></div>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                <script>
                    $(document).ready(function() {
                      
                        $('#competition').change(function() {
                            // Get the selected competition ID
                            var competitionId = $(this).val();
                            var action = '<?php echo $action; ?>'; 
                           
                            $.ajax({
                                type: 'GET',
                                url: 'basketball_female_' + action + '.php', 
                                data: { competition_id: competitionId },
                                success: function(response) {
                                    $('#content').html(response); 
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error:', error); 
                                }
                            });
                        });

                       
                        $("#competition").val($("#competition option:first").val()).change();
                    });
                </script>
                <?php
            } elseif ($action === 'news') {
                include('basketball_female_news.php');
            } else {
                include('basketball_female_standings.php');
            }
        } else {
            include('basketball_female_standings.php');
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
