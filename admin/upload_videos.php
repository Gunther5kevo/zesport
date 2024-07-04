<?php

include('includes/header.php')
?>


<div class="video-upload">
    <?= alertMessage();?>
    <h3>Upload New Video</h3>
    <form method="POST" enctype="multipart/form-data" class="row g-3" action="admin_functions.php">
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
            <input type="text" id="category" name="category" class="form-control" required>
        </div>
       
        <div class="col-12">
            <button type="submit" name="upload_video" class="btn btn-primary">Upload</button>
        </div>
    </form>
</div>


<h3>Delete Video</h3>





<?php include('includes/footer.php');?>