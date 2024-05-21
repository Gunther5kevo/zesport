
<?php
include('./admin_functions.php');
include('includes/header.php')
?>
 <div class="container mt-5">
        <h2 class="text-center mb-4">Upload Image</h2>
        <form action="admin_functions.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter description" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Upload Image</label>
                <input type="file" class="form-control-file" id="image" name="image" required>
            </div>
            <button type="submit" name="upload_image" class="btn btn-primary btn-block " >Upload</button>
        </form>
    </div>
    <?php include('includes/footer.php'); ?>