
<?php 
    include('includes/header.php');
?>

<div class="row">
            <div class="col-md-12">
                <div class="card">
                    <?= alertMessage(); ?>
                    <div class="card-body">
                        <p class="text-sm mb-0 text-capitalize">Create Blog Post</p>
                        <form method="POST" action="admin_functions.php" enctype="multipart/form-data" class="row g-3">
                            <div class="col-md-6">
                                <label for="title" class="form-label">Title:</label>
                                <input type="text" id="title" name="title" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="author" class="form-label">Author:</label>
                                <input type="text" id="author" name="author" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="date" class="form-label">Date:</label>
                                <input type="date" id="date" name="date" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <label for="content" class="form-label">Content:</label>
                                <textarea id="content" name="content" class="form-control" rows="5" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="image" class="form-label">Image:</label>
                                <input type="file" id="image" name="image" class="form-control">
                            </div>
                            <div class="col-12">
                                <button type="submit" name="create_post" class="btn btn-primary">Create Post</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php include('includes/footer.php'); ?>
