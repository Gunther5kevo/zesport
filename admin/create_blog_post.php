<?php
include('./admin_functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<section class="blog">
        <div class="blog-section">
        <h2>Create New Blog Post</h2>
            <form method="post" action="admin_post.php" enctype="multipart/form-data">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required><br>

                <label for="author">Author:</label>
                <input type="text" id="author" name="author" required><br>

                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required><br>

                <label for="content">Content:</label>
                <textarea id="content" name="content" required></textarea><br>

                <label for="image">Image:</label>
                <input type="file" id="image" name="image" required><br>

                <label for="link">Link:</label>
                <input type="text" id="link" name="link" required><br>

                <button type="submit" name="create_post">Create Post</button>
            </form>
    </section>
</body>
</html>