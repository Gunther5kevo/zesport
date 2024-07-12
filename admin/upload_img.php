<?php

include('includes/header.php');

// Fetch images from the database
$stmt = $pdo->query("SELECT id, title, image_url FROM features");
$uploadedImages = $stmt->fetchAll();

?>
<div class="container mt-5">
    <h2 class="text-center mb-4">Upload Image</h2>
    <?= alertMessage();?>
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
        <button type="submit" name="upload_image" class="btn btn-primary btn-block">Upload</button>
    </form>

    <h2 class="text-center mt-5 mb-4">Uploaded Images</h2>
    <div class="row">
        <?php foreach ($uploadedImages as $image): ?>
            <div class="col-md-2 text-center">
                <img src="<?= htmlspecialchars($image['image_url']); ?>" alt="<?= htmlspecialchars($image['title']); ?>" class="img-thumbnail" style="width: 100px; height: auto;">
                <form action="admin_functions.php" method="POST" class="mt-2">
                    <input type="hidden" name="delete_image_id" value="<?= $image['id']; ?>">
                    <button type="submit" name="delete_image" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include('includes/footer.php'); ?>
