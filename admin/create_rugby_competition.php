<?php

include('../datalayer/server.php');


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_competition'])) {
    $competitionName = htmlspecialchars($_POST['competition']);
    $gender = htmlspecialchars($_POST['gender']); 
    try {
        // Insert new competition into the database
        $sql = "INSERT INTO rugby_competitions (competition_name, gender) VALUES (:competition_name, :gender)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['competition_name' => $competitionName, 'gender' => $gender]);

        
        $_SESSION['status'] = "Competition created successfully";

        
        header("Location: admin_dashboard.php");
        exit();

    } catch (PDOException $e) {
        
        $_SESSION['status'] = "Error creating competition: " . $e->getMessage();
    }
} else {
    
    die('<h2>Unauthorized access</h2>');
}
