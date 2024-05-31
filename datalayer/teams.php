<?php

 
function fetchTeamsByGenderAndSport($pdo, $gender, $sportType) {
    $stmt = $pdo->prepare("SELECT * FROM teams WHERE gender = :gender AND sport_type = :sportType");
    $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
    $stmt->bindParam(':sportType', $sportType, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>