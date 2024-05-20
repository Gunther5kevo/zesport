<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Football - Sports Website</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/football.css">
</head>
<body>
  
    <nav id="custom-navbar">
        <div class="navbar-logo">
            <a href="index.php"><img src="path_to_your_logo_image.png" alt="Logo"></a>
        </div>
        <ul class="navbar-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="football.php?action=standings" <?php echo isset($_GET['action']) && $_GET['action'] === 'standings' ? 'class="active"' : ''; ?>>Standings</a></li>
            <li><a href="football.php?action=fixtures" <?php echo isset($_GET['action']) && $_GET['action'] === 'fixtures' ? 'class="active"' : ''; ?>>Fixtures</a></li>
            <li><a href="football.php?action=results" <?php echo isset($_GET['action']) && $_GET['action'] === 'results' ? 'class="active"' : ''; ?>>Results</a></li>
            <li><a href="football.php?action=news" <?php echo isset($_GET['action']) && $_GET['action'] === 'news' ? 'class="active"' : ''; ?>>News</a></li>
        </ul>
    </nav>

    <div class="container">
      

        <?php
        
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
            if ($action === 'results') {
                include('football_results.php');
            }elseif ($action  == 'fixtures'){
                include('football_fixtures.php');
            } elseif ($action === 'news') {
                include('football_news.php');
            } else {
                include('./standings/football_standings.php');
            }
        } else {
            include('./standings/football_standings.php');
        }
        ?>
    </div>

   
    

</body>
</html>
