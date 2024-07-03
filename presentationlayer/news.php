<?php
include('../datalayer/server.php');
include('../admin/includes/headerr.php');
include('../datalayer/blog.php');

$postId = isset($_GET['id']) ? intval($_GET['id']) : null;
$category = isset($_GET['category']) ? $_GET['category'] : null;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 5; // Number of posts per page

if ($postId) {
    $post = fetchSingleBlogPost($pdo, $postId);
}

$posts = fetchBlogPosts($pdo, $category, $perPage, $page);
$totalPosts = countTotalPosts($pdo, $category);
$totalPages = ceil($totalPosts / $perPage);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZEsport - News</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Open+Sans:wght@300&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="assets/css/news.css">
    <link rel="stylesheet" href="assets/css/contact.css">
    <meta name="description" content="Latest sports news and highlights from various competitions.">
    <meta name="keywords" content="sports, news, highlights, football, basketball, rugby">
    <meta name="author" content="ZEsport">
    <style>
    .news-item .card-img-top {
        max-width: 100%;
        height: auto;
        object-fit: cover;
    }
    </style>
</head>

<body>
    <?php include('header.php'); ?>

    <main>
        <section class="hero-section">
            <div class="container">
                <h1>Welcome to ZEsport News</h1>
                <p>Your source for the latest sports news and highlights.</p>
            </div>
        </section>

        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <section class="news-section">
                        <?php if ($postId && $post): ?>
                            <div class="news-item card">
                                <?php if (!empty($post['image'])) : ?>
                                <img src="../presentationlayer/assets/img/avatar/<?php echo htmlspecialchars($post['image']); ?>"
                                    alt="News Image" class="card-img-top">
                                <?php endif; ?>
                                <div class="card-body">
                                    <h2 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h2>
                                    <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php foreach ($posts as $post) : ?>
                            <div class="news-item card">
                                <div class="card-body">
                                    <h2 class="card-title">
                                        <a href="news.php?id=<?php echo htmlspecialchars($post['id']); ?>">
                                            <?php echo htmlspecialchars($post['title']); ?>
                                        </a>
                                    </h2>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <!-- Pagination -->
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                <li class="page-item <?php echo ($i === $page) ? 'active' : ''; ?>">
                                    <a class="page-link"
                                        href="?category=<?php echo urlencode($category); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    </section>
                </div>

                <!-- Sidebar -->
                <?php include('sidebar.php'); ?>
            </div>
        </div>

        <section class="video-section">
            <div class="container">
                <h2 class="section-heading">Video Highlights</h2>
                <div class="row">
                    <?php
                    include('../datalayer/video-section.php');
                    $categories = ['football', 'basketball', 'rugby'];
                    foreach ($categories as $category) {
                        $videos = getVideosByCategory($pdo, $category, 4);
                        if (!empty($videos) && is_array($videos)) {
                            echo '<div class="col-md-3 col-sm-6 mb-4">';
                            echo '<div class="video-card">';
                            echo '<div class="video-header">' . ucfirst($category) . ' Highlights</div>';
                            echo '<div class="video-thumbnail">';
                            foreach ($videos as $video) {
                                echo '<video class="video-player" controls>';
                                echo '<source src="' . htmlspecialchars($video['url']) . '" type="video/mp4">';
                                echo 'Your browser does not support the video tag.';
                                echo '</video>';
                            }
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                    ?>
                </div>
            </div>
        </section>
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
