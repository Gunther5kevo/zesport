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
            text-transform: sentencecase;
            margin-right: 10px;
        }
        .custom-navbar .navbar-brand {
            margin-left: 70px;
        }
        .dropdown-submenu {
            position: relative;
        }
        .dropdown-submenu .dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -1px;
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
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#" id="footballDropdown" role="button" aria-expanded="false">
                                Football
                            </a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="#" id="footballMenDropdown" role="button" aria-expanded="false">
                                        Men
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="football_men.php?action=standings">Standings</a></li>
                                        <li><a class="dropdown-item" href="football_men.php?action=fixtures">Fixtures</a></li>
                                        <li><a class="dropdown-item" href="football_men.php?action=results">Results</a></li>
                                        <li><a class="dropdown-item" href="football_men.php?action=news">News</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="#" id="footballWomenDropdown" role="button" aria-expanded="false">
                                        Women
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="football_women.php?action=standings">Standings</a></li>
                                        <li><a class="dropdown-item" href="football_women.php?action=fixtures">Fixtures</a></li>
                                        <li><a class="dropdown-item" href="football_women.php?action=results">Results</a></li>
                                        <li><a class="dropdown-item" href="football_women.php?action=news">News</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#" id="basketballDropdown" role="button" aria-expanded="false">
                                Basketball
                            </a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="#" id="basketballMenDropdown" role="button" aria-expanded="false">
                                        Men
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="basketball_men.php?action=standings">Standings</a></li>
                                        <li><a class="dropdown-item" href="basketball_men.php?action=fixtures">Fixtures</a></li>
                                        <li><a class="dropdown-item" href="basketball_men.php?action=results">Results</a></li>
                                        <li><a class="dropdown-item" href="basketball_men.php?action=news">News</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="#" id="basketballWomenDropdown" role="button" aria-expanded="false">
                                        Women
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="basketball_women.php?action=standings">Standings</a></li>
                                        <li><a class="dropdown-item" href="basketball_women.php?action=fixtures">Fixtures</a></li>
                                        <li><a class="dropdown-item" href="basketball_women.php?action=results">Results</a></li>
                                        <li><a class="dropdown-item" href="basketball_women.php?action=news">News</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#" id="rugbyDropdown" role="button" aria-expanded="false">
                                Rugby
                            </a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" href="#" id="rugbyMenDropdown" role="button" aria-expanded="false">
                                        Men
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="rugby_men.php?action=standings">Standings</a></li>
                                        <li><a class="dropdown-item" href="rugby_men.php?action=fixtures">Fixtures</a></li>
                                        <li><a class="dropdown-item" href="rugby_men.php?action=results">Results</a></li>
                                        <li><a class="dropdown-item" href="rugby_men.php?action=news">News</a></li>
                                    </ul>
                                </li>
                                <li><a class="dropdown-item" href="../presentationlayer/rugby_women.php">Women</a></li>
                            </ul>
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

<!-- Include necessary scripts for Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<!-- Custom JavaScript for handling multi-level dropdowns -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var dropdownSubmenus = document.querySelectorAll('.dropdown-submenu');

        dropdownSubmenus.forEach(function(submenu) {
            submenu.addEventListener('mouseenter', function() {
                var submenuDropdown = submenu.querySelector('.dropdown-menu');
                if (submenuDropdown) {
                    submenuDropdown.classList.add('show');
                }
            });

            submenu.addEventListener('mouseleave', function() {
                var submenuDropdown = submenu.querySelector('.dropdown-menu');
                if (submenuDropdown) {
                    submenuDropdown.classList.remove('show');
                }
            });
        });
    });
</script>
