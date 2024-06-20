<?php
// Include server.php for database connection and functions
include('../datalayer/server.php');


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_competition'])) {
    $competitionName = htmlspecialchars($_POST['competition']);
    $gender = htmlspecialchars($_POST['gender']); // Ensure this is 'male' or 'female' as needed for rugby

    try {
        // Insert new competition into the database
        $sql = "INSERT INTO basketballcompetitions (competition_name, gender) VALUES (:competition_name, :gender)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['competition_name' => $competitionName, 'gender' => $gender]);

        // Set success message to session
        $_SESSION['status'] = "Competition created successfully";

        // Redirect to dashboard to prevent form resubmission on page refresh
        header("Location: admin_dashboard.php");
        exit();

    } catch (PDOException $e) {
        // Set error message to session
        $_SESSION['status'] = "Error creating competition: " . $e->getMessage();
    }
} else {
    
    die('<h2>Unauthorized access</h2>');
}
?>