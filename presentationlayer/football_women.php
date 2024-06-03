<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Men's Football - ZeSport</title>
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
                        <a class="nav-link" href="football_women.php?action=standings">Standings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="football_women.php?action=fixtures">Fixtures</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="football_women.php?action=results">Results</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="football_women.php?action=news">News</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <?php
        // Handle PHP actions based on the 'action' parameter in the URL
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
            if ($action === 'results') {
                include('football_results_men.php');
            } elseif ($action === 'news') {
                include('football_news_men.php');
            } elseif ($action === 'fixtures') {
                include('female_fixtures.php');
            } else {
                include('./standings/female_standings.php');
            }
        } else {
            include('./standings/female_standings.php');
        }
        ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.1/js/bootstrap.min.js"></script>
</body>
</html>
