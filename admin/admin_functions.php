<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Include necessary files and setup database connection
require '../vendor/autoload.php'; // Include autoloader for FFMpeg library
use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\TimeCode;

include('../datalayer/server.php'); // Include database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Ensure a file was selected for upload
    if (isset($_FILES['video']) && $_FILES['video']['error'] === UPLOAD_ERR_OK) {
        // Get video details
        $videoName = $_FILES['video']['name'];
        $videoTmp = $_FILES['video']['tmp_name'];
        $title = $_POST['title'];
        $category = $_POST['category'];

        $videoPath = '../presentationlayer/assets/videos/' . $videoName;
        move_uploaded_file($videoTmp, $videoPath);

        // Generate thumbnail path
        $thumbnailPath = '../presentationlayer/assets/videos/' . pathinfo($videoName, PATHINFO_FILENAME) . '.png';

        // Create FFMpeg instance
        $ffmpeg = FFMpeg::create([
            'ffmpeg.binaries'  => 'C:\ProgramData\chocolatey\bin\ffmpeg.exe', 
            'ffprobe.binaries' => 'C:\ProgramData\chocolatey\bin\ffprobe.exe', // Specify path to ffprobe binary
        ]);

        // Open uploaded video using FFMpeg
        $video = $ffmpeg->open($videoPath);

        // Generate thumbnail at 10 seconds (adjust as needed)
        $video->frame(TimeCode::fromSeconds(10))->save($thumbnailPath);

        // Insert video details into database
        $query = "INSERT INTO videos (title, url, thumbnail, category, upload_date) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$title, $videoPath, $thumbnailPath, $category]);

        header('Location: upload_videos.php');
        exit();
    } else {
        // Handle file upload error
        echo "Error uploading video.";
    }
}

// Football fixture
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_fixture'])) {
    $match_date = $_POST['match_date'];
    $home_team = $_POST['home_team'];
    $away_team = $_POST['away_team'];
    $venue = $_POST['venue'];
    $referee = $_POST['referee'];
    $competition_id = $_POST['competition'];

    try {
        $sql = "INSERT INTO football_matches (match_date, home_team_id, away_team_id, competition_id, venue, referee)
                VALUES (:match_date, :home_team, :away_team, :competition_id, :venue, :referee)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'match_date' => $match_date,
            'home_team' => $home_team,
            'away_team' => $away_team,
            'competition_id' => $competition_id,
            'venue' => $venue,
            'referee' => $referee
        ]);

        
            // Your database connection and insertion code here
        
            // Display success alert and redirect
            echo '<script>alert("Team created successfully!"); window.location.href = "admin_dashboard.php";</script>';
            exit();
        } catch (PDOException $e) {
            // Handle database error
            echo '<script>alert("Insertion failed: ' . $e->getMessage() . '"); window.location.href = "admin_dashboard.php";</script>';
            exit();
        }
        
}

//Basketball fixture 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_basketball_fixture'])) {
    $match_date = $_POST['match_date'];
    $home_team = $_POST['home_team'];
    $away_team = $_POST['away_team'];
    $venue = $_POST['venue'];
    $referee = $_POST['referee'];
    $competition_id = $_POST['competition']; // Retrieve competition ID from form

    try {
        $sql = "INSERT INTO basketball_matches (match_date, home_team_id, away_team_id, competition_id, venue, referee)
                VALUES (:match_date, :home_team, :away_team, :competition_id, :venue, :referee)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'match_date' => $match_date,
            'home_team' => $home_team,
            'away_team' => $away_team,
            'competition_id' => $competition_id,
            'venue' => $venue,
            'referee' => $referee
        ]);

        // Redirect to admin dashboard after successful insertion
        header('Location: admin_dashboard.php');
        exit();
    } catch (PDOException $e) {
        // Handle database error
        echo 'Insertion failed: ' . $e->getMessage();
    }
}

    //rugby fixtures
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_rugby_fixture'])) {
        $match_date = $_POST['match_date'];
        $home_team = $_POST['home_team'];
        $away_team = $_POST['away_team'];
        $venue = $_POST['venue'];
        $referee = $_POST['referee'];
        $competition_id = $_POST['competition']; // Retrieve competition ID from form
    
        try {
            $sql = "INSERT INTO rugby_matches (match_date, home_team_id, away_team_id, competition_id, venue, referee)
                    VALUES (:match_date, :home_team, :away_team, :competition_id, :venue, :referee)";
    
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'match_date' => $match_date,
                'home_team' => $home_team,
                'away_team' => $away_team,
                'competition_id' => $competition_id,
                'venue' => $venue,
                'referee' => $referee
            ]);
    
            // Redirect to admin dashboard after successful insertion
            header('Location: admin_dashboard.php');
            exit();
        } catch (PDOException $e) {
            // Handle database error
            echo 'Insertion failed: ' . $e->getMessage();
        }
}
    // Scores
    //Football scores

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_football_scores'])) {
        // Check if all required fields are set
        if (isset($_POST['fixture_id'], $_POST['home_score'], $_POST['away_score'])) {
            // Sanitize input data
            $fixture_id = $_POST['fixture_id'];
            $home_score = $_POST['home_score'];
            $away_score = $_POST['away_score'];
    
            // Update the match scores in the database
            $sql = "UPDATE football_matches SET home_score = :home_score, away_score = :away_score WHERE id = :fixture_id";
    
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':home_score', $home_score, PDO::PARAM_INT);
            $stmt->bindParam(':away_score', $away_score, PDO::PARAM_INT);
            $stmt->bindParam(':fixture_id', $fixture_id, PDO::PARAM_INT);
    
            try {
                $stmt->execute();
                echo "<script>alert('Scores updated successfully.');</script>";
            } catch (PDOException $e) {
                echo "<script>alert('Error updating scores: " . $e->getMessage() . "');</script>";
            } 
                echo "<script>alert('All fields are required.');</script>";
            }
            
    }
    
    //Basketball Scores
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_basketball_scores'])) {
        // Check if all required fields are set
        if (isset($_POST['fixture_id'], $_POST['home_score'], $_POST['away_score'])) {
            // Sanitize input data
            $fixture_id = $_POST['fixture_id'];
            $home_score = $_POST['home_score'];
            $away_score = $_POST['away_score'];
    
            // Update the match scores in the database
            $sql = "UPDATE basketball_matches SET home_score = :home_score, away_score = :away_score WHERE id = :fixture_id";
    
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':home_score', $home_score, PDO::PARAM_INT);
            $stmt->bindParam(':away_score', $away_score, PDO::PARAM_INT);
            $stmt->bindParam(':fixture_id', $fixture_id, PDO::PARAM_INT);
    
            try {
                $stmt->execute();
                echo "<script>alert('Scores updated successfully.');</script>";
            } catch (PDOException $e) {
                echo "<script>alert('Error updating scores: " . $e->getMessage() . "');</script>";
            } 
                echo "<script>alert('All fields are required.');</script>";
            }
            
    } 
    
    //Rugby fixtures
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_rugby_scores'])) {
        // Check if all required fields are set
        if (isset($_POST['fixture_id'], $_POST['home_score'], $_POST['away_score'])) {
            // Sanitize input data
            $fixture_id = $_POST['fixture_id'];
            $home_score = $_POST['home_score'];
            $away_score = $_POST['away_score'];
    
            // Update the match scores in the database
            $sql = "UPDATE rugby_matches SET home_score = :home_score, away_score = :away_score WHERE id = :fixture_id";
    
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':home_score', $home_score, PDO::PARAM_INT);
            $stmt->bindParam(':away_score', $away_score, PDO::PARAM_INT);
            $stmt->bindParam(':fixture_id', $fixture_id, PDO::PARAM_INT);
    
            try {
                $stmt->execute();
                echo "<script>alert('Scores updated successfully.');</script>";
            } catch (PDOException $e) {
                echo "<script>alert('Error updating scores: " . $e->getMessage() . "');</script>";
            } 
                echo "<script>alert('All fields are required.');</script>";
            }
            
    } 

    //Blog posts 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_post'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $date = $_POST['date'];
    $content = $_POST['content'];
    $link = $_POST['link'];
    $image = '';

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = basename($_FILES['image']['name']);
        $imagePath = 'uploads/' . $imageName;
        move_uploaded_file($imageTmpPath, $imagePath);
        $image = $imagePath;
    }

    $sql = "INSERT INTO news_posts (title, author, date, content, image, link) VALUES (:title, :author, :date, :content, :image, :link)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':author', $author);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':link', $link);

    try {
        $stmt->execute();
        echo "Post created successfully.";
    } catch (PDOException $e) {
        echo "Error creating post: " . $e->getMessage();
    }
}


//Creating Teams 

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create_football_team"])) {
    // Include database connection
    

    // Get form data
    $team_name = $_POST['team_name'];

    // Insert data into the database
    $sql = "INSERT INTO teams (team_name) VALUES (:team_name)";
    $stmt = $pdo->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':team_name', $team_name);

    // Execute statement
    if ($stmt->execute()) {
        // Display success alert
        echo '<script>alert("Team created successfully!");</script>';
        // Redirect back to create_teams.php after 2 seconds
        echo '<script>window.setTimeout(function(){ window.location.href = "create_teams.php"; }, 2000);</script>';
    } else {
        // Display error alert
        echo '<script>alert("Error: Unable to create team.");</script>';
        // Redirect back to create_teams.php after 2 seconds
        echo '<script>window.setTimeout(function(){ window.location.href = "create_teams.php"; }, 2000);</script>';
    }
    
}

//Creating Rugby Teams
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create_rugby_team"])) {
    
    

    // Get form data
    $team_name = $_POST['team_name'];

    // Insert data into the database
    $sql = "INSERT INTO rugby_teams (team_name) VALUES (:team_name)";
    $stmt = $pdo->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':team_name', $team_name);

    // Execute statement
    if ($stmt->execute()) {
        // Display success alert
        echo '<script>alert("Team created successfully!");</script>';
        // Redirect back to create_teams.php after 2 seconds
        echo '<script>window.setTimeout(function(){ window.location.href = "create_teams.php"; }, 2000);</script>';
    } else {
        // Display error alert
        echo '<script>alert("Error: Unable to create team.");</script>';
        // Redirect back to create_teams.php after 2 seconds
        echo '<script>window.setTimeout(function(){ window.location.href = "create_teams.php"; }, 2000);</script>';
    }
    
}

//Creating Baketball teams
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create_basketball_team"])) {
    // Include database connection
    

    // Get form data
    $team_name = $_POST['team_name'];

    // Insert data into the database
    $sql = "INSERT INTO basketball_teams (team_name) VALUES (:team_name)";
    $stmt = $pdo->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':team_name', $team_name);

    // Execute statement
    if ($stmt->execute()) {
        // Display success alert
        echo '<script>alert("Team created successfully!");</script>';
        // Redirect back to create_teams.php after 2 seconds
        echo '<script>window.setTimeout(function(){ window.location.href = "create_teams.php"; }, 2000);</script>';
    } else {
        // Display error alert
        echo '<script>alert("Error: Unable to create team.");</script>';
        // Redirect back to create_teams.php after 2 seconds
        echo '<script>window.setTimeout(function(){ window.location.href = "create_teams.php"; }, 2000);</script>';
    }
    
}

//img upload

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['upload_image'])) {
    $title = htmlspecialchars($_POST['title']);
    $description = htmlspecialchars($_POST['description']);
    $image = $_FILES['image'];

    // Define the target directory
    $targetDir = "../presentationlayer/assets/img/avatar/";
    $targetFile = $targetDir . basename($image['name']);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if the file is an actual image
    $check = getimagesize($image['tmp_name']);
    if ($check === false) {
        $_SESSION['error'] = "File is not an image.";
    }

    // Check if the file already exists
    if (file_exists($targetFile)) {
        $_SESSION['error'] = "Sorry, file already exists.";
    }

    // Check file size (5MB maximum)
    if ($image['size'] > 5000000) {
        $_SESSION['error'] = "Sorry, your file is too large.";
    }

    // Allow certain file formats
    $allowedFormats = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowedFormats)) {
        $_SESSION['error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }

    // Try to upload the file
    if (!isset($_SESSION['error']) && move_uploaded_file($image['tmp_name'], $targetFile)) {
        
        $image_url = $targetFile; // Relative path from the project root
        $stmt = $pdo->prepare("INSERT INTO features (title, description, image_url) VALUES (?, ?, ?)");
        if ($stmt->execute([$title, $description, $image_url])) {
            $_SESSION['success'] = "The file " . htmlspecialchars(basename($image['name'])) . " has been uploaded and the record has been added to the database.";
        } else {
            $_SESSION['error'] = "Sorry, there was an error inserting the record into the database.";
        }
    } elseif (!isset($_SESSION['error'])) {
        $_SESSION['error'] = "Sorry, there was an error uploading your file.";
    }
    
    header("Location: admin_dashboard.php");
    exit();
}


?>












    
    
