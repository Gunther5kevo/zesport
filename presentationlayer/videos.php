<?php
include('../datalayer/server.php');
include('../admin/includes/headerr.php');
include('../datalayer/video-section.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZEsport - Videos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Open+Sans:wght@300&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="assets/css/news.css">
    <link rel="stylesheet" href="assets/css/contact.css">
    <meta name="description" content="Latest sports videos and highlights from various competitions.">
    <meta name="keywords" content="sports, videos, highlights, football, basketball, rugby">
    <meta name="author" content="ZEsport">
</head>

<body>
    <?php include('header.php'); ?>

    <main>
        <section class="hero-section">
            <div class="container">
                <h1>Welcome to ZEsport Videos</h1>
                <p>Enjoy the latest sports videos and highlights.</p>
            </div>
        </section>

        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <section class="video-section">
                        <?php
                        $categories = ['football', 'basketball', 'rugby'];
                        $videosByCategory = [];
                        foreach ($categories as $category) {
                            $videosByCategory[$category] = getVideosByCategory($pdo, $category, 4);
                        }
                        ?>
                        <div class="container">
                            <?php foreach ($videosByCategory as $category => $videos) : ?>
                            <?php if (!empty($videos) && is_array($videos)) : ?>
                            <!-- Check if $videos is not empty and is an array -->
                            <h2 class="section-heading"><?php echo ucfirst($category) ?> Highlights</h2>
                            <div class="row">
                                <?php foreach ($videos as $video) : ?>
                                <div class="col-md-3 col-sm-6 mb-4">
                                    <div class="video-card">
                                        <div class="video-header"><?php echo htmlspecialchars($video['title']); ?></div>
                                        <div class="video-thumbnail">
                                            <video class="video-player" controls>
                                                <source src="<?php echo htmlspecialchars($video['url']); ?>"
                                                    type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </section>
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
        $(document).ready(function () {
            // Example: Initialize modal or any other scripts
            $('#videoModal').modal('show');
        });
    </script>
</body>

</html>
