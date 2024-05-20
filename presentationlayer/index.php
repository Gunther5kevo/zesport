<?php
include ('../datalayer/server.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZEsport <?php echo ucfirst(basename($_SERVER['PHP_SELF'], '.php')); ?></title>
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
                        <a class="nav-link" href="news.php">News</a>
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

    

    <section class="img-section">
        <div class="container-fluid">
            <div id="sportsCarousel" class="carousel slide" data-ride="carousel">

                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#sportsCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#sportsCarousel" data-slide-to="1"></li>
                    <li data-target="#sportsCarousel" data-slide-to="2"></li>
                </ol>

                <div class="carousel-inner">

                    <div class="carousel-item active">
                        <img src="assets/img/foot.jpg" class="d-block w-100" alt="Football Image">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Football News</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco labor.</p>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <img src="assets/img/basketball.jpg" class="d-block w-100" alt="Basketball Image">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Basketball News</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco labor.</p>
                        </div>
                    </div>

                    <!-- Hockey Slide -->
                    <div class="carousel-item">
                        <img src="assets/img/rugby.jpg" class="d-block w-100" alt="Hockey Image">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Rugby News</h5>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco labor.</p>
                        </div>
                    </div>

                </div>

                <a class="carousel-control-prev" href="#sportsCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#sportsCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>

            </div>
        </div>
    </section> 
       
    <section class="features-section">
    <?php
        include('../datalayer/features.php');
        $features = fetchFeatures($pdo);
     ?>
    <div class="container">
        <div class="row">
            <?php foreach ($features as $feature) : ?>
                <div class="col-md-4">
                    <div class="feature-item">
                        <h3><?php echo htmlspecialchars($feature['title']); ?></h3>
                        <p><?php echo htmlspecialchars($feature['description']); ?></p>
                        <img src="<?php echo htmlspecialchars($feature['image_url']); ?>" class="d-block w-100" alt="<?php echo htmlspecialchars($feature['title']); ?>">
                        <a href="<?php echo htmlspecialchars($feature['link_url']); ?>" class="read-more">Read More</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    </section>

    <section carousel2-section>
    <div class="carousel-info">
    <div class="container">
        <div id="carousel-info" class="owl-carousel owl-theme"></div>
    </div>
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
                            <a href="news.php?video_url=<?php echo urlencode($video['url']); ?>&video_title=<?php echo urlencode($video['title']); ?>&video_description=<?php echo urlencode($video['description']); ?>">
                                <img src="<?php echo htmlspecialchars($video['thumbnail']); ?>" alt="<?php echo htmlspecialchars($video['title']); ?>">
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endforeach; ?>
        </div>
    </section>
    <section class="gallery">
        <div class="container">
        <div class="section-head">
            <h4>Gallery</h4>
            <div class="underline"></div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <a href="assets/img/avatar/gallery1.jpg" class="image-popup"><img class="img-fluid" src="assets/img/avatar/gallery1.jpg" alt="Sample Image"></a>
            </div>
            <div class="col-md-4">
                <a href="assets/img/avatar/gallery2.jpg" class="image-popup"><img class="img-fluid" src="assets/img/avatar/gallery2.jpg" alt="Sample Image"></a>
            </div>
            <div class="col-md-4">
                <a href="assets/img/avatar/gallery3.jpg" class="image-popup"><img class="img-fluid" src="assets/img/avatar/gallery3.jpg" alt="Sample Image"></a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <a href="assets/img/avatar/gallery4.jpg" class="image-popup"><img class="img-fluid" src="assets/img/avatar/gallery4.jpg" alt="Sample Image"></a>
            </div>
            <div class="col-md-4">
                <a href="assets/img/avatar/gallery5.jpg" class="image-popup"><img class="img-fluid" src="assets/img/avatar/gallery5.jpg" alt="Sample Image"></a>
            </div>
            <div class="col-md-4">
                <a href="assets/img/avatar/gallery6.jpg" class="image-popup"><img class="img-fluid" src="assets/img/avatar/gallery6.jpg" alt="Sample Image"></a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <a href="assets/img/avatar/gallery7.jpg" class="image-popup"><img class="img-fluid" src="assets/img/avatar/gallery7.jpg" alt="Sample Image"></a>
            </div>
            <div class="col-md-4">
                <a href="assets/img/avatar/gallery8.jpg" class="image-popup"><img class="img-fluid" src="assets/img/avatar/gallery8.jpg" alt="Sample Image"></a>
            </div>
            <div class="col-md-4">
                <a href="assets/img/avatar/gallery9.jpg" class="image-popup"><img class="img-fluid" src="assets/img/avatar/gallery9.jpg" alt="Sample Image"></a>
            </div>
        </div>
     </div>
    </section>

    <section class="testimonial-section">
        <div class="testimonial">
            <img src="" alt="User 1">
            <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium."</p>
            <span class="user-name">John Doe</span>
        </div>
        <div class="testimonial">
            <img src="user2.jpg" alt="User 2">
            <p>"Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem."</p>
            <span class="user-name">Jane Smith</span>
        </div>
    </section>

</main>
<footer>
    <?php include('./footer.php'); ?>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

<script>
       $(document).ready(function() {
        $('.image-popup').magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            }
        });
    });
</script>

</body>
</html>
