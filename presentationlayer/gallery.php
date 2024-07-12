<?php
include ('../datalayer/server.php');
include('../admin/includes/headerr.php');

// Fetch images from the database
$stmt = $pdo->query("SELECT title, image_url FROM features");
$uploadedImages = $stmt->fetchAll();
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
    <link rel="stylesheet" href="assets/css/contact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
</head>

<body>
    <main>
        <section class="gallery">
            <div class="container">
                <div class="section-head">
                    <h4>Gallery</h4>
                    <div class="underline"></div>
                </div>
                <div class="row">
                    <!-- Static Images -->
                    <div class="col-md-4">
                        <a href="assets/img/avatar/gallery1.jpg" data-lightbox="gallery"><img class="img-fluid" src="assets/img/avatar/gallery1.jpg" alt="Sample Image"></a>
                    </div>
                    <div class="col-md-4">
                        <a href="assets/img/avatar/gallery2.jpg" data-lightbox="gallery"><img class="img-fluid" src="assets/img/avatar/gallery2.jpg" alt="Sample Image"></a>
                    </div>
                    <div class="col-md-4">
                        <a href="assets/img/avatar/gallery3.jpg" data-lightbox="gallery"><img class="img-fluid" src="assets/img/avatar/gallery3.jpg" alt="Sample Image"></a>
                    </div>
                    <div class="col-md-4">
                        <a href="assets/img/avatar/gallery4.jpg" data-lightbox="gallery"><img class="img-fluid" src="assets/img/avatar/gallery4.jpg" alt="Sample Image"></a>
                    </div>
                    <div class="col-md-4">
                        <a href="assets/img/avatar/gallery5.jpg" data-lightbox="gallery"><img class="img-fluid" src="assets/img/avatar/gallery5.jpg" alt="Sample Image"></a>
                    </div>
                    <div class="col-md-4">
                        <a href="assets/img/avatar/gallery6.jpg" data-lightbox="gallery"><img class="img-fluid" src="assets/img/avatar/gallery6.jpg" alt="Sample Image"></a>
                    </div>
                    <div class="col-md-4">
                        <a href="assets/img/avatar/gallery7.jpg" data-lightbox="gallery"><img class="img-fluid" src="assets/img/avatar/gallery7.jpg" alt="Sample Image"></a>
                    </div>
                    <div class="col-md-4">
                        <a href="assets/img/avatar/gallery8.jpg" data-lightbox="gallery"><img class="img-fluid" src="assets/img/avatar/gallery8.jpg" alt="Sample Image"></a>
                    </div>
                    <div class="col-md-4">
                        <a href="assets/img/avatar/gallery9.jpg" data-lightbox="gallery"><img class="img-fluid" src="assets/img/avatar/gallery9.jpg" alt="Sample Image"></a>
                    </div>

                    <!-- Dynamic Uploaded Images -->
                    <?php foreach ($uploadedImages as $image): ?>
                        <div class="col-md-4">
                            <a href="<?= htmlspecialchars($image['image_url']); ?>" data-lightbox="gallery">
                                <img class="img-fluid" src="<?= htmlspecialchars($image['image_url']); ?>" alt="<?= htmlspecialchars($image['title']); ?>">
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <?php include('./footer.php'); ?>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
</body>

</html>
