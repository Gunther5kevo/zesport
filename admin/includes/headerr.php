<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website Title</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
<nav class="navbar navbar-expand-lg navbar-dark custom-navbar sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="../presentationlayer/assets/img/zetechlogo.png" alt="Zetech University" style="max-width: 20%; height: auto;" class="d-inline-block align-top">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="../presentationlayer/index.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="footballDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Football
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="footballDropdown">
                        <li><a class="dropdown-item" href="../presentationlayer/football_men.php">Men</a></li>
                        <li><a class="dropdown-item" href="../presentationlayer/football_women.php">Women</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="basketballDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Basketball
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="basketballDropdown">
                        <li><a class="dropdown-item" href="../presentationlayer/basketball_men.php">Men</a></li>
                        <li><a class="dropdown-item" href="../presentationlayer/basketball_women.php">Women</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="rugbyDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Rugby
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="rugbyDropdown">
                        <li><a class="dropdown-item" href="../presentationlayer/rugby_men.php">Men</a></li>
                        <li><a class="dropdown-item" href="../presentationlayer/rugby_women.php">Women</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../presentationlayer/news.php">News</a>
                </li>
                <?php if (isset($_SESSION['auth'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../admin/logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../admin/login.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
