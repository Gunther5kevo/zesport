<?php
include('../datalayer/server.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZEsport - News</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Open+Sans:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

<main>
<section class="nav-section">
        <nav id="navbar" class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
            <a class="navbar-brand" href="index.php">ZEsport</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="football.php">Football</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="basketball.php">Basketball</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="rugby.php">Rugby</a>
                    </li>
                </ul>
            </div>
        </nav>
</section>
    <?php
        include('../datalayer/blog.php');
        
        $perPage = 6;
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $category = isset($_GET['category']) ? $_GET['category'] : null;

        $posts = fetchBlogPosts($pdo, $category, $perPage, $page);
        $totalPosts = countTotalPosts($pdo, $category);
        $totalPages = ceil($totalPosts / $perPage);
    ?>  
    <section class="news-section">
        <div class="container">
            <div class="row">
                <?php foreach ($posts as $post) : ?>
                    <div class="col-md-6">
                        <div class="news-item">
                            <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="News Image">
                            <h2><?php echo htmlspecialchars($post['title']); ?></h2>
                            <p class="meta">
                                <span class="author">By <?php echo htmlspecialchars($post['author']); ?></span>
                                <span class="date"><?php echo htmlspecialchars($post['date']); ?></span>
                            </p>
                            <p><?php echo htmlspecialchars($post['content']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
                 
                 <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <li class="page-item <?php echo ($i === $page) ? 'active' : ''; ?>">
                            <a class="page-link" href="?category=<?php echo urlencode($category); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    </section>

    <?php
    include('../datalayer/video-section.php');
    $categories = ['football', 'basketball', 'rugby'];
    foreach ($categories as $category) {
        $videosByCategory = getVideosByCategory($pdo, $category, 4);
        if (!empty($videosByCategory)) {
        echo '<section class="video-section">';
        echo '<div class="container">';
        echo '<h2 class="section-heading">' . ucfirst($category) . ' Highlights</h2>'; // Apply section-heading class here
        echo '<div class="row">';
        foreach ($videosByCategory as $video) {
            echo '<div class="col-md-4 mb-4">';
            echo '<div class="video-item">';
            echo '<h3>' . htmlspecialchars($video['title']) . '</h3>';
            echo '<div class="video-thumbnail">';
            echo '<a href="news.php?video_url=' . urlencode($video['url']) . '&video_title=' . urlencode($video['title']) . '&video_description=' . urlencode($video['description']) . '">';
            echo '<img src="' . htmlspecialchars($video['thumbnail']) . '" alt="' . htmlspecialchars($video['title']) . '">';
            echo '</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
        echo '</div>';
        echo '</section>';
    }
}
?>

        </div>
    </section>


</main>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="assets/js/scripts.js">
    
    $(document).ready(function() {
        $('#videoModal').modal('show');
    });
</script>
<footer>
    <?php include('footer.php'); ?>
</footer>

</body>
</html>
