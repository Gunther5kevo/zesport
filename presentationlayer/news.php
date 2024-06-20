<?php
include('../datalayer/server.php');
include('../admin/includes/headerr.php');
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
    <meta name="description" content="Latest sports news and highlights from various competitions.">
    <meta name="keywords" content="sports, news, highlights, football, basketball, rugby">
    <meta name="author" content="ZEsport">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        /* Hero Section */
        .hero-section {
            background: url('assets/img/hero.jpg') no-repeat center center/cover;
            color: white;
            padding: 100px 0;
            text-align: center;
        }

        .hero-section h1 {
            font-size: 3em;
            margin-bottom: 20px;
        }

        .hero-section p {
            font-size: 1.5em;
        }

        /* News Section */
        .news-section {
            padding: 40px 0;
        }

        .news-item {
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .news-item:hover {
            transform: translateY(-5px);
        }

        .card-body {
            display: flex;
            flex-direction: column;
            flex: 1;
            padding: 20px;
        }

        .card-title {
            font-size: 1.5em;
            margin-bottom: 10px;
        }

        .card-text {
            flex-grow: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.5;
            height: 150px;
        }

        .meta {
            margin-bottom: 10px;
            font-size: 0.9em;
            color: #666;
        }

        .meta .author,
        .meta .date {
            display: block;
        }

        .pagination {
            margin-top: 20px;
        }

        /* Video Section */
        .video-section {
            padding: 40px 0;
        }

        .section-heading {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .video-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .video-card:hover {
            transform: translateY(-5px);
        }

        .video-header {
            padding: 10px;
            background-color: #3a87ad;
            color: #fff;
            font-weight: bold;
            text-align: center;
        }

        .video-thumbnail {
            position: relative;
            padding-top: 56.25%;
            background-color: #000;
        }

        .video-thumbnail video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        @media (max-width: 768px) {
            .video-header {
                font-size: 14px;
                padding: 8px;
            }
        }

        @media (max-width: 576px) {
            .video-header {
                font-size: 12px;
                padding: 6px;
            }
        }
    </style>
</head>
<body>
<?php include('header.php'); ?>

<main>
    <section class="hero-section">
        <h1>Welcome to ZEsport News</h1>
        <p>Your source for the latest sports news and highlights.</p>
    </section>

    <section class="news-section">
        <?php
        $staticPosts = [
            [
                'image' => 'assets/img/titans.png',
                'title' => 'Higher and Higher',
                'author' => 'Kevin',
                'date' => 'June 5, 2024',
                'content' => 'Introducing to you the Kenya Basketball Federation Div 1 2021 champions.'
            ],
            [
                'image' => 'assets/img/rugby22.png',
                'title' => 'Sisi ndio Machampe!',
                'author' => 'Admin',
                'date' => 'June 2, 2024',
                'content' => 'Zetech Oaks are the Kenya Rugby Union Nationwide League 2023/24 season champions after emerging victorious against the Technical University of Mombasa (TUM) Marines with a 31-13 win in a final held at the RFUEA Grounds in Nairobi on Saturday.'
            ]
        ];

        include('../datalayer/blog.php');
        $perPage = 6;
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $category = isset($_GET['category']) ? $_GET['category'] : null;
        $posts = fetchBlogPosts($pdo, $category, $perPage, $page);
        $totalPosts = countTotalPosts($pdo, $category);
        $totalPages = ceil($totalPosts / $perPage);
        ?>
        <div class="container">
            <div class="row">
                <?php foreach ($staticPosts as $post) : ?>
                    <div class="col-md-6 d-flex">
                        <div class="news-item card flex-fill">
                            <img src="<?php echo htmlspecialchars($post['image']); ?>" alt="News Image" class="card-img-top">
                            <div class="card-body d-flex flex-column">
                                <h2 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h2>
                                <p class="meta">
                                    <span class="author">By <?php echo htmlspecialchars($post['author']); ?></span>
                                    <span class="date"><?php echo htmlspecialchars($post['date']); ?></span>
                                </p>
                                <p class="card-text"><?php echo htmlspecialchars($post['content']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php foreach ($posts as $post) : ?>
                    <div class="col-md-6 d-flex">
                        <div class="news-item card flex-fill">
                            <?php if (!empty($post['image'])) : ?>
                                <img src="../presentationlayer/assets/img/avatar/<?php echo htmlspecialchars($post['image']); ?>" alt="News Image" class="card-img-top">
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <h2 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h2>
                                <p class="meta">
                                    <span class="author">By <?php echo htmlspecialchars($post['author']); ?></span>
                                    <span class="date"><?php echo htmlspecialchars($post['date']); ?></span>
                                </p>
                                <p class="card-text"><?php echo htmlspecialchars($post['content']); ?></p>
                            </div>
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
                <h2 class="section-heading"><?php echo ucfirst($category) ?> Highlights</h2>
                <div class="row">
                    <?php foreach ($videos as $video) : ?>
                        <div class="col-md-3 col-sm-6 mb-4">
                            <div class="video-card">
                                <div class="video-header"><?php echo htmlspecialchars($video['title']); ?></div>
                                <div class="video-thumbnail">
                                    <video class="video-player" controls>
                                        <source src="<?php echo htmlspecialchars($video['url']); ?>" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
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
        $('#videoModal').modal('show');
    });
</script>
</body>
</html>
