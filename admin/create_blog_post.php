
<?php 
    include('includes/header.php');
?>

    <div class="row">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <div class="card-body">
                        <form action="admin_functions.php" method="POST">
                            <div class="col-md-6">
                                
                                     <label for="title">Title:</label>
                                    <input type="text" id="title" name="title" required><br>
                                
                            </div>
                            <div class="col-md-8">
                                 
                                    <label for="author">Author:</label>
                                    <input type="text" id="author" name="author" required><br>
                                
                                </div>
                                <div class="col-md-8">
                                
                                    <label for="date">Date:</label>
                                    <input type="date" id="date" name="date" required><br>
                                    
                                </div>
                                <div class="col-md-8">
                                
                                    <label for="content">Content:</label>
                                    <textarea id="content" name="content" required></textarea><br>
                                    
                                </div>
                                <div class="col-md-6">
                                
                                    <label for="image">Image:</label>
                                    <input type="file" id="image" name="image" required><br>
                                    
                                </div>
                                <div class="col-md-6">
                                
                                    <label for="link">Link:</label>
                                    <input type="text" id="link" name="link" required><br>
                                    
                                </div>
                                <div class="col-md-6">
                                
                                    <button type="submit" name="create_post">Create Post</button>
                                    
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('includes/footer.php'); ?>
