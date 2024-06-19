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
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Open+Sans:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
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
        </div>
    </div>
</section>


</main>
</body>
<footer>
    <?php include('./footer.php'); ?>
</footer>
</html>