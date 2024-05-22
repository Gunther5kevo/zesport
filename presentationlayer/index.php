<?php
include ('../datalayer/server.php');
include('../admin/includes/navbar.php')
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

    <!-- features -->
    <section class="feature-section">
    <style>
    .container{
        margin-bottom: 30px;
    }
    .card {
        height: 500px;
        border-radius: 5px; 
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
        transition: box-shadow 0.3s ease; 
        margin-bottom: 30px;
    }

    .card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); 
        
    }
    .btn-primary{
        bottom: 10px;
        transform: translateX(100%);
        margin-top: 12px;;
        background-color: #1C1D3C;

    }
       
    </style>

    <div class="container">
    <?php
    include('../datalayer/features.php');
    $features = fetchFeatures($pdo);

    if (!empty($features)) {
        echo '<div class="row">';
        foreach ($features as $feature) {
            echo '<div class="col-md-4">';
            echo '<div class="card feature-item">';
            echo '<img src="' . $feature['image_url'] . '" class="card-img-top" alt="' . $feature['title'] . '">';
            echo '<div class="card-body">';
            echo '<h3 class="card-title">' . htmlspecialchars($feature['title']) . '</h3>';
            echo '<p class="card-text">' . htmlspecialchars($feature['description']) . '</p>';
            echo '<a href="' . $feature['link_url'] . '" class="read-more">Read More</a>';
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

  // Define the categories
  $categories = ['football', 'basketball', 'rugby'];

  // Initialize an empty array to store videos by category
  $videosByCategory = [];

  // Fetch videos for each category
  foreach ($categories as $category) {
      $videosByCategory[$category] = getVideosByCategory($pdo, $category, 4);
  }
  ?>
  
  <div class="container">
    <div class="row">
      <?php foreach ($videosByCategory as $category => $videos) : ?>
        <div class="col-md-4 mb-4">
          <div class="card">
            <div class="card-header">
              <h2><?php echo htmlspecialchars(ucwords($category)) ?> Highlights</h2>
            </div>
            <div class="card-body">
              <?php foreach ($videos as $video) : ?>
                <div class="video-item">
                  <h3><?php echo htmlspecialchars($video['title']); ?></h3>
                  <p><?php echo htmlspecialchars($video['description']); ?></p>
                  <div class="video-thumbnail">
                    <a href="news.php?video_url=<?php echo urlencode($video['url']); ?>&video_title=<?php echo urlencode($video['title']); ?>&video_description=<?php echo urlencode($video['description']); ?>">
                      <img src="<?php echo htmlspecialchars($video['thumbnail']); ?>" alt="<?php echo htmlspecialchars($video['title']); ?>">
                    </a>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
         <?php endforeach; ?>
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
            <img src="assets/img/avatar/profile1.jpg" alt="User 1">
            <p>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium."</p>
            <span class="user-name">John Doe</span>
        </div>
        <div class="testimonial">
            <img src="assets/img/avatar/profile2.jpg" alt="User 2">
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
