<?php

// Function to fetch blog posts with pagination
function fetchBlogPosts($pdo, $category, $perPage, $page) {
    try {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM news_posts";
        if (!empty($category)) {
            $sql .= " WHERE category = :category";
        }
        $sql .= " ORDER BY date DESC LIMIT :perPage OFFSET :offset";

        $stmt = $pdo->prepare($sql);
        if (!empty($category)) {
            $stmt->bindParam(':category', $category, PDO::PARAM_STR);
        }
        $stmt->bindParam(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error fetching posts: " . $e->getMessage();
        return [];
    }
}

// Function to count total posts
function countTotalPosts($pdo, $category) {
    try {
        $sql = "SELECT COUNT(*) AS total FROM news_posts";
        if (!empty($category)) {
            $sql .= " WHERE category = :category";
        }

        $stmt = $pdo->prepare($sql);
        if (!empty($category)) {
            $stmt->bindParam(':category', $category, PDO::PARAM_STR);
        }
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    } catch (PDOException $e) {
        echo "Error counting total posts: " . $e->getMessage();
        return 0;
    }
}

// Ensure that the id parameter is present in the URL
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = max(1, intval($_GET['page']));
}

$category = isset($_GET['category']) ? $_GET['category'] : null;
$perPage = 5; // Number of posts per page

$posts = fetchBlogPosts($pdo, $category, $perPage, $page);
$totalPosts = countTotalPosts($pdo, $category);
$totalPages = ceil($totalPosts / $perPage);



function fetchPopularPosts($pdo) {
    try {
        // Prepare SQL statement to fetch popular posts based on views
        $stmt = $pdo->query("SELECT * FROM news_posts ORDER BY views DESC LIMIT 5");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        
        echo "Error: " . $e->getMessage();
        return []; 
    }
}


