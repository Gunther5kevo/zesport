<?php
include('../datalayer/server.php');
include('../admin/includes/headerr.php')
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
        <?php foreach ($videosByCategory as $category => $videos) : ?>
          <h2 class="section-heading"><?php echo ucfirst($category) ?> Highlights</h2>
          <div class="row">
            <?php foreach ($videos as $video) : ?>
              <div class="col-md-3 mb-4">
                <!-- <div class="card">
                  <div class="card-header"><?php echo htmlspecialchars($video['title']); ?></div>
                  <div class="card-body"> -->
                    <div class="video-thumbnail">
                      <!-- Video Player -->
                      <video class="card-img-top" width="100%" controls>
                        <source src="<?php echo htmlspecialchars($video['url']); ?>" type="video/mp4">
                        Your browser does not support the video tag.
                      </video>
                    </div>
                    <p class="card-text"><?php echo htmlspecialchars($video['description']); ?></p>
                  <!-- </div>
                </div>
              </div> -->
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
