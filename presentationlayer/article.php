<?php
// Ensure that the id parameter is present in the URL
if (!isset($_GET['id'])) {
    // Redirect to a generic error page or back to the main page
    header('Location: index.php');
    exit;
}

// Include necessary PHP files and start HTML output
include('../datalayer/server.php');
include('../admin/includes/headerr.php');

// Function to increment post views based on ID
function incrementPostViews($pdo, $postId) {
    try {
        // Prepare SQL statement to update views count for the specified post
        $stmt = $pdo->prepare("UPDATE news_posts SET views = views + 1 WHERE id = ?");
        $stmt->execute([$postId]);
    } catch (PDOException $e) {
        // Handle PDO exception (e.g., log or display an error message)
        echo "Error: " . $e->getMessage();
    }
}

// Function to fetch article details by ID
function fetchArticleById($pdo, $postId) {
    try {
        // Prepare SQL statement to fetch the article by its ID
        $stmt = $pdo->prepare("SELECT * FROM news_posts WHERE id = ?");
        $stmt->execute([$postId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle PDO exception (e.g., log or display an error message)
        echo "Error: " . $e->getMessage();
        return false;
    }
}

// Ensure the id parameter is a valid integer
$articleId = intval($_GET['id']);

// Increment views for the article based on its ID
incrementPostViews($pdo, $articleId);

// Fetch article details based on the ID
$article = fetchArticleById($pdo, $articleId);

// Redirect to main page if article is not found
if (!$article) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZEsport - Article</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Open+Sans:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/contact.css">
    <meta name="description" content="Detailed article content from ZEsport.">
    <meta name="keywords" content="sports, news, article, highlights, football, basketball, rugby">
    <meta name="author" content="ZEsport">
</head>
<body>


<main>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <article class="single-article">
                    <h1 class="article-title"><?php echo htmlspecialchars($article['title']); ?></h1>
                    <p class="article-meta">
                        <span class="article-author">By <?php echo htmlspecialchars($article['author']); ?></span>
                        <span class="article-date"><?php echo htmlspecialchars($article['date']); ?></span>
                    </p>
                    <?php if (!empty($article['image'])) : ?>
                        <img src="../presentationlayer/assets/img/avatar/<?php echo htmlspecialchars($article['image']); ?>" alt="Article Image" class="article-image img-fluid mb-3">
                    <?php endif; ?>
                    <div class="article-content">
                        <?php echo htmlspecialchars_decode($article['content']); ?>
                    </div>
                </article>
            </div>
        </div>
    </div>
</main>

<footer>
    <?php include('footer.php'); ?>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        // Example: Initialize modal or any other scripts
        $('#videoModal').modal('show');
    });
</script>
</body>
</html>
