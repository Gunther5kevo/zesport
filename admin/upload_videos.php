<?php

include('includes/header.php')
?>


<div class="video-upload">
    <?= alertMessage();?>
    <h3>Upload New Video</h3>
    <form method="POST" enctype="multipart/form-data" class="row g-3">
        <div class="col-md-6">
            <label for="title" class="form-label">Title:</label>
            <input type="text" id="title" name="title" class="form-control" required>
        </div>
        <div class="col-md-6">
        <label for="video" class="form-label">Choose Video File:</label>
        <div class="input-group">
        <input type="file" id="video" name="video" class="form-control" accept="video/*" required>
        </div>
        </div>

        <div class="col-md-6">
            <label for="category" class="form-label">Category:</label>
            <input type="text" id="category" name="category" class="form-control" required><!-- Or replace input type with select for predefined categories -->
        </div>
        <!-- You can add additional inputs here if needed -->
        <div class="col-12">
            <button type="submit" name="submit" class="btn btn-primary">Upload</button>
        </div>
    </form>
</div>


<h3>Delete Video</h3>
<div class="video-gallery row">
    <?php
    include('../datalayer/video-section.php');
    $sql = "SELECT id, title, thumbnail FROM videos";
    $stmt = $pdo->query($sql);

    // Fetch videos as an associative array
    $videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($videos as $video) {
        echo '<div class="col-md-4">';
        echo '<div class="video-item">';
        echo '<img src="' . $video['thumbnail'] . '" class="img-fluid" alt="' . $video['title'] . '">';
        echo '<p>' . $video['title'] . '</p>';
        echo '<a href="delete_video.php?id=' . $video['id'] . '" class="btn btn-danger">Delete</a>';
        echo '</div>';
        echo '</div>';
    }
    ?>
</div>



<?php include('includes/footer.php');?>