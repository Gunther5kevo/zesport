<?php
include('../datalayer/server.php');
include('../admin/includes/headerr.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: news.php");
    exit;
}
  
include('../datalayer/blog.php');
$postId = intval($_GET['id']);
$post = fetchSingleBlogPost($pdo, $postId);

if (!$post) {
    header("Location: news.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?> - ZEsport News</title>
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
  

    <main>
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <div class="news-item card">
                        <?php if (!empty($post['image'])) : ?>
                        <img src="../presentationlayer/assets/img/avatar/<?php echo htmlspecialchars($post['image']); ?>"
                            alt="News Image" class="card-img-top">
                        <?php endif; ?>
                        <div class="card-body">
                            <h2 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h2>
                            <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                            <!-- You can add other details like author, date, etc. -->
                        </div>
                        
                    </div>
                </div>

                <!-- Sidebar -->
                <?php include('sidebar.php'); ?>
            </div>
        </div>
    </main>

    <footer>
        <?php include('footer.php'); ?>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
