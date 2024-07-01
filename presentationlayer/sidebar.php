<!-- sidebar.php -->
<div class="col-lg-4">
    <aside class="sidebar">
        <!-- Live Scores -->
        <div class="live-scores mb-4">
            <h2>Live Scores</h2>
            <!-- Example live scores, replace with dynamic data -->
            <ul>
                <li>Fkf women: Zetech sparks 2 - 1 Bunyore</li>
                <li>Kpl: Titans 3 - 0 Jkuat</li>
                <!-- Add more live scores dynamically here -->
            </ul>
        </div>

        <!-- Popular Articles -->
        <div class="popular-articles mb-4">
            <h2>Popular Articles</h2>
            <ul>
                <?php
                // Example: fetch popular posts (replace with actual function)
                $popularPosts = fetchPopularPosts($pdo);
                foreach ($popularPosts as $post) :
                ?>
                    <li><a href="article.php?id=<?php echo $post['id']; ?>"><?php echo htmlspecialchars($post['title']); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Social Media Links -->
        <div class="social-media">
            <h2>Follow Us</h2>
            <ul class="social-links">
                <li><a href="#">Facebook</a></li>
                <li><a href="#">Twitter</a></li>
                <li><a href="#">Instagram</a></li>
                <!-- Add more social media links here -->
            </ul>
        </div>
    </aside>
</div>
