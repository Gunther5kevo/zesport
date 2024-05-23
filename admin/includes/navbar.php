
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

<nav class="navbar navbar-expand-lg navbar-dark custom-navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
        <img src="../presentationlayer/assets/img/logo.png" alt="Zetech University" style="max-width: 100px; height: auto;" class="d-inline-block align-top">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                        <a class="nav-link" href="../presentationlayer/index.php">Home</a>
                    </li>
                <li class="nav-item">
                        <a class="nav-link" href="../presentationlayer/football.php">Football</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../presentationlayer/basketball.php">Basketball</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="../presentationlayer/rugby.php">Rugby</a>
                    </li>
                   
                    <li class="nav-item">
                        <a class="nav-link" href="../presentationlayer/news.php">News</a>
                    </li>              
                   
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
        </div>
    </div>
</nav>

<!-- Include the necessary Bootstrap and FontAwesome scripts for the sidebar toggler to function properly -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.1/js/bootstrap.min.js"></script> -->
