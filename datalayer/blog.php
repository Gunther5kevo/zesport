<?php
function fetchBlogPosts($pdo, $category = null, $limit = 6, $page = 1) {
    // Calculate the offset based on the page and limit
    $offset = ($page - 1) * $limit;

    // Build the SQL query to fetch posts
    $query = "SELECT * FROM news_posts";

    // If a category is specified, add a WHERE clause to filter by category
    if ($category) {
        $query .= " WHERE category = :category";
    }

    // Add LIMIT and OFFSET clauses for pagination
    $query .= " LIMIT :limit OFFSET :offset";

    // Prepare the SQL statement
    $stmt = $pdo->prepare($query);

    // Bind parameters
    if ($category) {
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
    }
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

    // Execute the query
    $stmt->execute();

    // Fetch all rows as associative arrays
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function countTotalPosts($pdo, $category = null) {
    // Build the SQL query to count total posts
    $query = "SELECT COUNT(*) FROM news_posts";

    // If a category is specified, add a WHERE clause to filter by category
    if ($category) {
        $query .= " WHERE category = :category";
    }

    // Prepare the SQL statement
    $stmt = $pdo->prepare($query);

    // Bind parameters
    if ($category) {
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
    }

    // Execute the query
    $stmt->execute();

    // Fetch the total count
    return $stmt->fetchColumn();
}

