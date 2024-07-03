<?php

// Function to fetch blog posts with pagination
function fetchBlogPosts($pdo, $category, $perPage, $page) {
    try {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT id, title FROM news_posts";
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

// Function to fetch a single blog post by ID
function fetchSingleBlogPost($pdo, $id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM news_posts WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error fetching post: " . $e->getMessage();
        return null;
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


