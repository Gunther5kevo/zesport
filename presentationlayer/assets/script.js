$(document).ready(function() {
    
    $('.comment-form').submit(function(e) {
        e.preventDefault();
        var form = $(this);
        var postId = form.find('input[name="postId"]').val();
        var commentText = form.find('textarea[name="comment"]').val();

        $.post({
            url: '../datalayer/add_comment.php',
            data: {
                postId: postId,
                comment: commentText
            },
            success: function(response) {
                
                fetchComments(postId);
                
                form[0].reset();
            }
        });
    });

    
    function fetchComments(postId) {
        $.get({
            url: '../datalayer/fetch_comments.php',
            data: { postId: postId },
            success: function(data) {
                $('#commentsList_' + postId).html(data);
            }
        });
    }

    // Initial load of comments for all news posts
    $('.news-item').each(function() {
        var postId = $(this).find('input[name="postId"]').val();
        fetchComments(postId);
    });
});
$(document).ready(function() {
    var sports = ['football', 'basketball', 'rugby']; 
    var currentIndex = 0;

    function loadResults(sport) {
        $.ajax({
            url: sport + '_daily.php', 
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#carousel-info').empty(); 

               
                data.forEach(function(result) {
                    var itemHtml = `
                        <div class="item">
                            <div class="content">
                                <h6>${result.home_team} <span>${result.home_score}</span></h6>
                                <h6>${result.away_team} <span>${result.away_score}</span></h6>
                            </div>
                        </div>
                    `;
                    $('#carousel-info').append(itemHtml);
                });

                // Initialize Owl Carousel
                $('#carousel-info').owlCarousel({
                    items: 3,
                    loop: true,
                    autoplay: true,
                    autoplayTimeout: 5000, // Interval between automatic switches (5 seconds)
                    autoplayHoverPause: true,
                    responsive: {
                        0: {
                            items: 1
                        },
                        600: {
                            items: 2
                        },
                        1000: {
                            items: 3
                        }
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    }

    // Function to load results for the current sport category
    function loadCurrentSportResults() {
        var currentSport = sports[currentIndex];
        loadResults(currentSport);
        currentIndex = (currentIndex + 1) % sports.length; // Cycle through sports array
    }

    // Call loadCurrentSportResults initially and then at specified intervals
    loadCurrentSportResults(); // Load initial results

    // Set interval to load results for the next sport category
    setInterval(loadCurrentSportResults, 5000); // Switch sports every 5 seconds
});