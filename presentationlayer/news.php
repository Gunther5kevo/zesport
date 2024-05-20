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

    
    <section class="video-section">
    <?php
        include('../datalayer/video-section.php');
        $categories = ['football', 'basketball', 'rugby'];
        $videosByCategory = [];

        foreach ($categories as $category) {
            $videosByCategory[$category] = getVideosByCategory($pdo, $category, 4);
        }
    ?>
        <div class="container">
        <?php foreach ($videosByCategory as $category => $videos) : ?>
            <h2><?php echo htmlspecialchars(ucwords($category)) ?> Highlights</h2>
            <div class="row">
                <?php foreach ($videos as $video) : ?>
                    <div class="col-md-4 mb-4">
                        <div class="video-item">
                            <h3><?php echo htmlspecialchars($video['title']); ?></h3>
                            <p><?php echo htmlspecialchars($video['description']); ?></p>
                            <div class="video-thumbnail">
                                <!-- Video Player -->
                                <video width="320" height="240" controls>
                                    <source src="<?php echo htmlspecialchars($video['url']); ?>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                <!-- Thumbnail (Optional) -->
                                <a href="news.php?video_url=<?php echo urlencode($video['url']); ?>&video_title=<?php echo urlencode($video['title']); ?>&video_description=<?php echo urlencode($video['description']); ?>">
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
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
