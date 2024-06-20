<?php

include ('../datalayer/server.php');
include('../admin/includes/headerr.php')
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZEsport <?php echo ucfirst(basename($_SERVER['PHP_SELF'], '.php')); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Open+Sans:wght@300&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body>
    <main>
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
                            <img src="assets/img/foot1.jpg" class="d-block w-100" alt="Football Image">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Zetech Sparks</h5>
                                <p>A last one for the 2023/2024 season 🤗.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="assets/img/basketball.jpg" class="d-block w-100" alt="Basketball Image">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Champions!! 👏🏀</h5>
                                <p>Zetech Sparks are the new basketball champions of the Eliud Owalo Foundation Elite
                                    Tournament after defeating arch-rivals KPA 59-50 in the finals on Sunday at the
                                    Ulinzi Complex, Nairobi.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="assets/img/img3.jpg" class="d-block w-100" alt="Rugby Image">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Rugby News</h5>
                                <p>Hats off to these unwavering disciples of the game, who have etched their characters
                                    on the pitch every single day, pouring their hearts out for what they believe in!
                                    🏉🌟</p>
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



        <!-- features -->
        <section class="feature-section">
            <div class="container">
                <?php
        include('../datalayer/features.php');
        $features = fetchFeatures($pdo);

        if (!empty($features)) {
            echo '<div class="row">';
            foreach ($features as $feature) {
                echo '<div class="col-md-4">';
                echo '<div class="card feature-item">';
                echo '<img src="' . htmlspecialchars($feature['image_url']) . '" class="card-img-top" alt="' . htmlspecialchars($feature['title']) . '">';
                echo '<div class="card-body">';
                echo '<h3 class="card-title">' . htmlspecialchars($feature['title']) . '</h3>';
                echo '<p class="card-text">' . htmlspecialchars($feature['description']) . '</p>';
                echo '<a href="' . htmlspecialchars($feature['link_url']) . '" class="read-more">Read More</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo "<p>No features found</p>";
        }
        ?>
            </div>
        </section>


        <!-- <section class="carousel2-section">
            <div class="carousel-info">
                <div class="container">
                    <div id="carousel-info" class="carousel-inner">
                        <div class="item active">
                            <div class="content">
                                <h6>Lorem FC <span>0</span></h6>
                                <h6>Ipsumdo FC <span>2</span></h6>
                            </div>
                        </div>
                         Repeat this structure for each match result -->
                        <!-- <div class="item">
                            <div class="content">
                                <h6>FC Dolor <span>0</span></h6>
                                <h6>Ipsumdo FC <span>2</span></h6>
                            </div>
                        </div>
                        
                    </div>
                    
                    <a class="carousel-control-prev" href="#carousel-info" role="button" data-slide="prev">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <a class="carousel-control-next" href="#carousel-info" role="button" data-slide="next">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </div>
        </section>
         --> 

        <section class="video-section">
            <div class="container">
                <div class="row">
                    <!-- Football Highlights -->
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h2>Football Highlights</h2>
                            </div>
                            <div class="card-body">
                                <div class="video-item">
                                    <div class="video-description">
                                        <h3>Zetech Titans Fc</h3>
                                    </div>
                                    <div>
                                        <p> Always ready to showcase their talent and emerge victorious in any
                                            competition.</p>
                                    </div>
                                    <div class="video-thumbnail">
                                        <a
                                            href="news.php?video_url=football_video_1.mp4&video_title=Football Video Title 1&video_description=Short description of football video 1.">
                                            <img src="assets/videos/Snapinsta.app_video_10000000_1616873835747587_7128927841519552347_n.png"
                                                alt="Football Video Title 1">
                                            <i class="play-icon fas fa-play-circle"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Basketball Highlights -->
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h2>Basketball Highlights</h2>
                            </div>
                            <div class="card-body">
                                <div class="video-item">
                                    <div class="video-description">
                                        <h3>Titans on the go</h3>
                                    </div>
                                    <div>
                                        <p>Zetech Titans manifesting their skills in the court.</p>
                                    </div>
                                    <div class="video-thumbnail">
                                        <a
                                            href="news.php?video_url=basketball_video_1.mp4&video_title=Basketball Video Title 1&video_description=Short description of basketball video 1.">
                                            <img src="assets/videos/Snapinsta.app_video_B640673080DE5DCB4536559DF0E52E8D_video_dashinit.png"
                                                alt="Basketball Video Title 1">
                                            <i class="play-icon fas fa-play-circle"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rugby Highlights -->
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h2>Rugby Highlights</h2>
                            </div>
                            <div class="card-body">
                                <div class="video-item">
                                    <div class="video-description">
                                        <h3>New kit for the rugby team</h3>
                                    </div>
                                    <div>
                                        <p>A boost to the rugby squad after the school unveils new kit for them.</p>
                                    </div>
                                    <div class="video-thumbnail">
                                        <a
                                            href="news.php?video_url=rugby_video_1.mp4&video_title=Rugby Video Title 1&video_description=Short description of rugby video 1.">
                                            <img src="assets/videos/Snapinsta.app_video_438966095_466569592499138_8280443329152143839_n.png"
                                                alt="Rugby Video Title 1">
                                            <i class="play-icon fas fa-play-circle"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                        <a href="gallery.php"><img class="img-fluid" src="assets/img/avatar/gallery1.jpg"
                                alt="Sample Image"></a>
                    </div>
                    <div class="col-md-4">
                        <a href="gallery.php"><img class="img-fluid" src="assets/img/avatar/gallery4.jpg"
                                alt="Sample Image"></a>
                    </div>
                    <div class="col-md-4">
                        <a href="gallery.php"><img class="img-fluid" src="assets/img/avatar/gallery5.jpg"
                                alt="Sample Image"></a>
                    </div>
                </div>
            </div>
        </section>



        <section class="testimonial-section">
            <div class="testimonial">
                <img src="assets/img/avatar/profile1.jpg" alt="User 1">
                <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut perspiciatis unde omnis iste natus
                    error sit voluptatem accusantium doloremque laudantium."</p>
                <span class="user-name">John Doe</span>
            </div>
            <div class="testimonial">
                <img src="assets/img/avatar/profile2.jpg" alt="User 2">
                <p>"Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur
                    magni dolores eos qui ratione voluptatem."</p>
                <span class="user-name">Jane Smith</span>
            </div>
        </section>

    </main>
    <footer>
        <?php include('./footer.php'); ?>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
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