<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zesport</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .custom-navbar {
            background-color: #1C1D3C !important;
            font-family: "Times New Roman", Times, serif;
            font-size: 18px;
            line-height: 1.2em;
            color: #ffffff;
        }
        .custom-navbar .navbar-nav .nav-link {
            color: #ffffff !important;
            text-transform: capitalize;
            margin-right: 10px;
            white-space: nowrap; /* Prevents wrapping to the next line */
        }
        .custom-navbar .navbar-brand {
            margin-left: 70px;
        }
        .navbar-nav {
            flex-wrap: nowrap; /* Prevents wrapping of the entire navbar */
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark custom-navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="../presentationlayer/assets/img/zetechlogo.png" alt="Zetech University" style="max-width: 20%; height: auto;" class="d-inline-block align-top">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="../presentationlayer/index.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="sportsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Sports
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="sportsDropdown">
                        <li>
                            <a class="dropdown-item" href="../presentationlayer/football.php">Football</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="../presentationlayer/basketball.php">Basketball</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="../presenatationlayer/rugby.php">Rugby</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../presentationlayer/news.php">News</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../presentationlayer/about.php">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../presentationlayer/contact.php">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../presentationlayer/gallery.php">Gallery</a>
                </li>
                <?php if (isset($_SESSION['auth'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./login.php">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Include necessary scripts for Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

