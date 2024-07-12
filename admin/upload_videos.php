<?php
include('includes/header.php');
?>

<div class="video-upload">
    <?= alertMessage(); ?>
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

<div class="video-delete">
    <form method="POST" action="admin_functions.php">
        <label for="video_id" class="form-label">Select Video to Delete:</label>
        <select id="video_id" name="video_id" class="form-control" required>
            <?php
            // Fetch videos from the database
            $query = "SELECT id, title, thumbnail FROM videos";
            $stmt = $pdo->query($query);
            while ($row = $stmt->fetch()) {
                echo "<option value='" . $row['id'] . "'><img src='" . $row['thumbnail'] . "' alt='thumbnail' style='width: 20px; height: 20px;' /> " . $row['title'] . "</option>";
            }
            ?>
        </select>
        <button type="submit" name="delete_video" class="btn btn-danger">Delete</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>
