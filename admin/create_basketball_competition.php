<?php
// Include your database connection file
include('../datalayer/server.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_competition'])) {
    // Sanitize and retrieve form data
    $competitionName = htmlspecialchars($_POST['competition']);
    $gender = htmlspecialchars($_POST['gender']);
    $seasonId = (int)$_POST['season']; // Assuming season_id is posted as an integer

    try {
        // Insert new competition into the database
        $sql = "INSERT INTO basketballcompetitions (competition_name, gender, season_id) VALUES (:competition_name, :gender, :season_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['competition_name' => $competitionName, 'gender' => $gender, 'season_id' => $seasonId]);

        // Set success message to session
        $_SESSION['status'] = "Competition created successfully";

        // Redirect to dashboard to prevent form resubmission on page refresh
        header("Location: admin_dashboard.php");
        exit();

    } catch (PDOException $e) {
        // Set error message to session
        $_SESSION['status'] = "Error creating competition: " . $e->getMessage();
        
        // Redirect to previous page to handle errors
        header("Location: admin_dashboard.php");
        exit();
    }
} else {
    // Unauthorized access handling
    die('<h2>Unauthorized access</h2>');
}
