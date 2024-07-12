<?php
// Include server.php for database connection and functions
include('../datalayer/server.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_competition'])) {
    $competitionName = htmlspecialchars($_POST['competition']);
    $gender = htmlspecialchars($_POST['gender']); // Ensure this is 'male' or 'female' as needed for rugby
    $seasonName = htmlspecialchars($_POST['season']); // Season input from the form

    try {
        // Fetch season_id based on season_name
        $seasonQuery = "SELECT id FROM seasons WHERE season_name = :season_name";
        $stmtSeason = $pdo->prepare($seasonQuery);
        $stmtSeason->execute(['season_name' => $seasonName]);
        $seasonRow = $stmtSeason->fetch(PDO::FETCH_ASSOC);

        if (!$seasonRow) {
            // Handle error if season doesn't exist
            $_SESSION['status'] = "Season not found";
            header("Location: admin_dashboard.php");
            exit();
        }

        $seasonId = $seasonRow['id'];

        // Insert new competition into the database
        $sql = "INSERT INTO competitions (competition_name, gender, season_id) VALUES (:competition_name, :gender, :season_id)";
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
        header("Location: admin_dashboard.php"); // Adjust the redirection as per your application flow
        exit();
    }
} else {
    // Handle unauthorized access
    die('<h2>Unauthorized access</h2>');
}

