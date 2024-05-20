<?php
function fetchNewsPosts($pdo) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM news_posts ORDER BY date DESC LIMIT 4");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error fetching news posts: " . $e->getMessage());
    }
}


$newsPosts = fetchNewsPosts($pdo);
?>
