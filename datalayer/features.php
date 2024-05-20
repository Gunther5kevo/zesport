<?php


function fetchFeatures($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM features");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error fetching features: " . $e->getMessage());
    }
}

$features = fetchFeatures($pdo);
?>