<?php

include('../datalayer/server.php'); // Include database connection file
include('functions.php');


require '../vendor/autoload.php'; 



use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\TimeCode;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['upload_video'])) {
        // Handle video upload
        if (isset($_FILES['video']) && $_FILES['video']['error'] === UPLOAD_ERR_OK) {
            $videoName = $_FILES['video']['name'];
            $videoTmp = $_FILES['video']['tmp_name'];
            $title = isset($_POST['title']) ? $_POST['title'] : '';
            $category = isset($_POST['category']) ? $_POST['category'] : '';

            $videoDirectory = '../presentationlayer/assets/videos/';
            $thumbnailDirectory = '../presentationlayer/assets/videos/';

            $videoPath = $videoDirectory . uniqid() . '_' . $videoName;
            $thumbnailPath = $thumbnailDirectory . uniqid() . '_' . pathinfo($videoName, PATHINFO_FILENAME) . '.png';

            if (move_uploaded_file($videoTmp, $videoPath)) {
                $ffmpeg = FFMpeg::create([
                    'ffmpeg.binaries'  => 'C:\ProgramData\chocolatey\bin\ffmpeg.exe', 
                    'ffprobe.binaries' => 'C:\ProgramData\chocolatey\bin\ffprobe.exe',
                ]);

                $video = $ffmpeg->open($videoPath);
                $video->frame(TimeCode::fromSeconds(10))->save($thumbnailPath);

                $query = "INSERT INTO videos (title, url, thumbnail, category, upload_date) VALUES (:title, :url, :thumbnail, :category, NOW())";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':url', $videoPath);
                $stmt->bindParam(':thumbnail', $thumbnailPath);
                $stmt->bindParam(':category', $category);

                if ($stmt->execute()) {
                    $_SESSION['status'] = "Video uploaded successfully.";
                    header('Location: upload_videos.php');
                    exit();
                } else {
                    $_SESSION['status'] = "Error inserting video details into database.";
                    header('Location: upload_videos.php');
                    exit();
                }
            } else {
                $_SESSION['status'] = "Error moving uploaded video to destination directory.";
                header('Location: upload_videos.php');
                exit();
            }
        } else {
            $_SESSION['status'] = "Error uploading video.";
            header('Location: upload_videos.php');
            exit();
        }
    } elseif (isset($_POST['delete_video'])) {
        // Handle video deletion
        $video_id = $_POST['video_id'];

        // Fetch the video details
        $query = "SELECT url, thumbnail FROM videos WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $video_id);
        $stmt->execute();
        $video = $stmt->fetch();

        if ($video) {
            $videoPath = $video['url'];
            $thumbnailPath = $video['thumbnail'];

            // Delete the file from the server
            if (file_exists($videoPath)) {
                unlink($videoPath);
            }
            if (file_exists($thumbnailPath)) {
                unlink($thumbnailPath);
            }

            // Delete the video record from the database
            $query = "DELETE FROM videos WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $video_id);
            if ($stmt->execute()) {
                $_SESSION['status'] = "Video deleted successfully.";
                header('Location: upload_videos.php');
                exit();
            } else {
                $_SESSION['status'] = "Error deleting video from database.";
                header('Location: upload_videos.php');
                exit();
            }
        } else {
            $_SESSION['status'] = "Video not found.";
            header('Location: upload_videos.php');
            exit();
        }
    }
}


// Football fixture



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_fixture'])) {
    $match_date = $_POST['match_date'];
    $match_time = $_POST['match_time']; 
    $home_team = $_POST['home_team'];
    $away_team = $_POST['away_team'];
    $venue = $_POST['venue'];
    $referee = $_POST['referee'];
    $competition_id = $_POST['competition'];
    
    $gender = $_POST['gender']; 

    try {
        $sql = "INSERT INTO football_matches (match_date, match_time, home_team_id, away_team_id, competition_id, venue, referee, gender)
                VALUES (:match_date, :match_time, :home_team, :away_team, :competition_id,:venue, :referee, :gender)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'match_date' => $match_date,
            'match_time' => $match_time,
            'home_team' => $home_team,
            'away_team' => $away_team,
            'competition_id' => $competition_id,
            
            'venue' => $venue,
            'referee' => $referee,
            'gender' => $gender // Bind the gender parameter
        ]);

        // Set success message
        $_SESSION['status'] = "Fixture created successfully!";
        // Redirect to admin dashboard
        header("Location: create_football_fixtures.php");
        exit();
    } catch (PDOException $e) {
        // Set error message
        $_SESSION['status'] = "Insertion failed: " . $e->getMessage();
        // Redirect to admin dashboard
        header("Location: create_football_fixtures.php");
        exit();
    }
}




//Basketball fixture 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_basketball_fixture'])) {
    $match_date = $_POST['match_date'];
    $match_time = $_POST['match_time']; 
    $home_team = $_POST['home_team'];
    $away_team = $_POST['away_team'];
    $venue = $_POST['venue'];
    $referee = $_POST['referee'];
    $competition_id = $_POST['competition'];
    
    $gender = $_POST['gender']; 

    try {
        $sql = "INSERT INTO basketball_matches (match_date, match_time, home_team_id, away_team_id, competition_id, venue, referee, gender)
                VALUES (:match_date, :match_time, :home_team, :away_team, :competition_id,:venue, :referee, :gender)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'match_date' => $match_date,
            'match_time' => $match_time,
            'home_team' => $home_team,
            'away_team' => $away_team,
            'competition_id' => $competition_id,
            
            'venue' => $venue,
            'referee' => $referee,
            'gender' => $gender // Bind the gender parameter
        ]);

        // Set success message
        $_SESSION['status'] = "Fixture created successfully!";
        // Redirect to admin dashboard
        header("Location: create_basketball_fixtures.php");
        exit();
    } catch (PDOException $e) {
        // Set error message
        $_SESSION['status'] = "Insertion failed: " . $e->getMessage();
        // Redirect to admin dashboard
        header("Location: create_basketball_fixtures.php");
        exit();
    }
}


    //rugby fixtures

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_rugby_fixture'])) {
        $match_date = $_POST['match_date'];
        $match_time = $_POST['match_time']; 
        $home_team = $_POST['home_team'];
        $away_team = $_POST['away_team'];
        $venue = $_POST['venue'];
        $referee = $_POST['referee'];
        $competition_id = $_POST['competition'];
        
        $gender = $_POST['gender']; 
    
        try {
            $sql = "INSERT INTO rugby_matches (match_date, match_time, home_team_id, away_team_id, competition_id, venue, referee, gender)
                    VALUES (:match_date, :match_time, :home_team, :away_team, :competition_id,:venue, :referee, :gender)";
    
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'match_date' => $match_date,
                'match_time' => $match_time,
                'home_team' => $home_team,
                'away_team' => $away_team,
                'competition_id' => $competition_id,
                
                'venue' => $venue,
                'referee' => $referee,
                'gender' => $gender 
            ]);
    
            // Set success message
            $_SESSION['status'] = "Fixture created successfully!";
            // Redirect to admin dashboard
            header("Location: create_rugby_fixtures.php");
            exit();
        } catch (PDOException $e) {
            // Set error message
            $_SESSION['status'] = "Insertion failed: " . $e->getMessage();
            // Redirect to admin dashboard
            header("Location: create_rugby_fixtures.php");
            exit();
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
                // Display success alert
                $_SESSION['status'] = 'Scores updated successfully.';
            } catch (PDOException $e) {
                // Display error alert
                $_SESSION['status'] = 'Error updating scores: ' . $e->getMessage();
            }
        } else {
            // Display alert for missing fields
            $_SESSION['status'] = 'All fields are required.';
        }
        // Redirect back to the same page after processing
        header('Location: update_football_scores.php' );
        exit();
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
                // Display success alert
                $_SESSION['status'] = 'Scores updated successfully.';
            } catch (PDOException $e) {
                // Display error alert
                $_SESSION['status'] = 'Error updating scores: ' . $e->getMessage();
            }
        } else {
            // Display alert for missing fields
            $_SESSION['status'] = 'All fields are required.';
        }
        // Redirect back to the same page after processing
        header('Location: update_basketball_scores.php');
        exit();
}
    
    //Rugby Scores
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
        $image = '';
    
        // Handle file upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageTmpPath = $_FILES['image']['tmp_name'];
            $imageName = basename($_FILES['image']['name']);
            $imagePath = '../presentationlayer/assets/img/avatar/' . $imageName;
            
            if (move_uploaded_file($imageTmpPath, $imagePath)) {
                $image = $imageName;
            } else {
                echo "<div class='alert alert-danger'>Error uploading image.</div>";
                exit;
            }
        }
    
        $sql = "INSERT INTO news_posts (title, author, date, content, image) VALUES (:title, :author, :date, :content, :image)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':image', $image);
        
    
        try {
            $stmt->execute();
            echo "<div class='alert alert-success'>Post created successfully.</div>";
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Error creating post: " . $e->getMessage() . "</div>";
        }
    }

//Creating Teams 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create_football_team"])) {
    // Assuming $pdo is your PDO database connection object
    $team_name = isset($_POST['team_name']) ? $_POST['team_name'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';

    if (!empty($team_name) && !empty($gender)) {
        try {
            // Prepare the SQL statement with named placeholders
            $sql = "INSERT INTO teams (team_name, gender) VALUES (:team_name, :gender)";
            $stmt = $pdo->prepare($sql);

            // Bind the parameters to the named placeholders
            $stmt->bindParam(':team_name', $team_name);
            $stmt->bindParam(':gender', $gender);

            // Execute the prepared statement
            if ($stmt->execute()) {
                redirect('create_teams.php', "Football team created successfully!");
            } else {
                redirect('create_teams.php', "Error: Unable to create football team.");
            }
        } catch (PDOException $e) {
            // Handle database errors
            redirect('create_teams.php', "Database error: " . $e->getMessage());
        }
    } else {
        redirect('create_teams.php', "Team name and gender are required.");
    }
}


//Creating Rugby Teams

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create_rugby_team"])) {
    // Assuming $pdo is your PDO database connection object
    $team_name = isset($_POST['team_name']) ? $_POST['team_name'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';

    if (!empty($team_name) && !empty($gender)) {
        try {
            // Prepare the SQL statement with named placeholders
            $sql = "INSERT INTO rugby_teams (team_name, gender) VALUES (:team_name, :gender)";
            $stmt = $pdo->prepare($sql);

            // Bind the parameters to the named placeholders
            $stmt->bindParam(':team_name', $team_name);
            $stmt->bindParam(':gender', $gender);

            // Execute the prepared statement
            if ($stmt->execute()) {
                redirect('create_teams.php', "Rugby team created successfully!");
            } else {
                redirect('create_teams.php', "Error: Unable to create rugby team.");
            }
        } catch (PDOException $e) {
            // Handle database errors
            redirect('create_teams.php', "Database error: " . $e->getMessage());
        }
    } else {
        redirect('create_teams.php', "Team name and gender are required.");
    }
}



//Creating Baketball teams

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["create_basketball_team"])) {
    // Assuming $pdo is your PDO database connection object
    $team_name = isset($_POST['team_name']) ? $_POST['team_name'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';

    if (!empty($team_name) && !empty($gender)) {
        try {
            // Prepare the SQL statement with named placeholders
            $sql = "INSERT INTO basketball_teams (team_name, gender) VALUES (:team_name, :gender)";
            $stmt = $pdo->prepare($sql);

            // Bind the parameters to the named placeholders
            $stmt->bindParam(':team_name', $team_name);
            $stmt->bindParam(':gender', $gender);

            // Execute the prepared statement
            if ($stmt->execute()) {
                redirect('create_teams.php', "Basketball team created successfully!");
            } else {
                redirect('create_teams.php', "Error: Unable to create basketball team.");
            }
        } catch (PDOException $e) {
            // Handle database errors
            redirect('create_teams.php', "Database error: " . $e->getMessage());
        }
    } else {
        redirect('create_teams.php', "Team name and gender are required.");
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
        $_SESSION['status'] = "File is not an image.";
    }

    // Check if the file already exists
    if (file_exists($targetFile)) {
        $_SESSION['status'] = "Sorry, file already exists.";
    }

    // Check file size (5MB maximum)
    if ($image['size'] > 5000000) {
        $_SESSION['status'] = "Sorry, your file is too large.";
    }

    // Allow certain file formats
    $allowedFormats = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowedFormats)) {
        $_SESSION['status'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }

    // Try to upload the file
    if (!isset($_SESSION['status']) && move_uploaded_file($image['tmp_name'], $targetFile)) {
        $image_url = $targetFile; // Relative path from the project root
        $stmt = $pdo->prepare("INSERT INTO features (title, description, image_url) VALUES (?, ?, ?)");
        if ($stmt->execute([$title, $description, $image_url])) {
            $_SESSION['status'] = "The file " . htmlspecialchars(basename($image['name'])) . " has been uploaded and the record has been added to the database.";
        } else {
            $_SESSION['status'] = "Sorry, there was an error inserting the record into the database.";
        }
    } elseif (!isset($_SESSION['status'])) {
        $_SESSION['status'] = "Sorry, there was an error uploading your file.";
    }

    header("Location: upload_img.php");
    exit();
}

// Image Delete Code
if (isset($_POST['delete_image'])) {
    $imageId = $_POST['image_id'];
    $stmt = $pdo->prepare("SELECT image_url FROM features WHERE id = ?");
    $stmt->execute([$imageId]);
    $image = $stmt->fetch();

    if ($image) {
        $imagePath = $image['image_url'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        $stmt = $pdo->prepare("DELETE FROM features WHERE id = ?");
        if ($stmt->execute([$imageId])) {
            $_SESSION['status'] = "Image deleted successfully.";
        } else {
            $_SESSION['status'] = "Failed to delete the image from the database.";
        }
    } else {
        $_SESSION['status'] = "Image not found.";
    }

    header("Location: upload_img.php");
    exit();
}




//Adding and Editing users

if (isset($_POST['saveUser'])) {
   
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $role = isset($_POST['role']) ? $_POST['role'] : '';
    $is_ban = isset($_POST['is_ban']) ? ($_POST['is_ban'] == true ? 1 : 0) : 0;

    if (!empty($name) && !empty($email) && !empty($phone) && !empty($password)) {
        try {
            // Prepare the SQL statement with named placeholders
            $sql = "INSERT INTO users (name, phone, email, password, role, is_ban) 
                    VALUES (:name, :phone, :email, :password, :role, :is_ban)";
            $stmt = $pdo->prepare($sql);

            // Bind parameters to named placeholders
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':is_ban', $is_ban);

            // Execute the prepared statement
            if ($stmt->execute()) {
                redirect('users.php', 'User/Admin added successfully');
            } else {
                redirect('users-create.php', 'Something went wrong');
            }
        } catch (PDOException $e) {
            // Handle database errors
            redirect('users-create.php', 'Database error: ' . $e->getMessage());
        }
    } else {
        redirect('users-create.php', 'All fields are required');
    }
}


if (isset($_POST['updateUser'])) {
    $id = validate($_POST['user_id']);
    $name = validate($_POST['name']);
    $phone = validate($_POST['phone']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $role = validate($_POST['role']);
    $is_ban = isset($_POST['is_ban']) ? 1 : 0;

    try {
        $query = "UPDATE users SET name = :name, phone = :phone, email = :email, password = :password, role = :role, is_ban = :is_ban WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'password' => $password,
            'role' => $role,
            'is_ban' => $is_ban,
            'id' => $id
        ]);

        $_SESSION['message'] = 'User updated successfully';
        $_SESSION['alert_type'] = 'success';
    } catch (PDOException $e) {
        $_SESSION['message'] = 'Failed to update user: ' . $e->getMessage();
        $_SESSION['alert_type'] = 'danger';
    }

    header('Location: users-edit.php');
    exit();
}

//creating competitions 



?>



















    
    
