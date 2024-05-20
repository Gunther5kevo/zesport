<?php
function fetchBlogPosts($pdo, $category = null, $limit = 6, $page = 1) {
    $offset = ($page - 1) * $limit;
    $query = "SELECT * FROM posts";

    if ($category) {
        $query .= " WHERE category = ?";
    }

    $query .= " ORDER BY date DESC LIMIT ? OFFSET ?";
    
    $stmt = $pdo->prepare($query);

    if ($category) {
        $stmt->bindParam(1, $category, PDO::PARAM_STR);
        $stmt->bindParam(2, $limit, PDO::PARAM_INT);
        $stmt->bindParam(3, $offset, PDO::PARAM_INT);
    } else {
        $stmt->bindParam(1, $limit, PDO::PARAM_INT);
        $stmt->bindParam(2, $offset, PDO::PARAM_INT);
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function countTotalPosts($pdo, $category = null) {
    $query = "SELECT COUNT(*) FROM posts";

    if ($category) {
        $query .= " WHERE category = ?";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(1, $category, PDO::PARAM_STR);
    } else {
        $stmt = $pdo->query($query);
    }

    $stmt->execute();
    return $stmt->fetchColumn();
}
?>
