// JavaScript for displaying live scores dynamically
document.addEventListener('DOMContentLoaded', function() {
    // Function to fetch live scores from the server
    function fetchLiveScores() {
        // Make an AJAX request to fetch live scores
        fetch('fetch_live_scores.php') // Replace 'fetch_live_scores.php' with your server-side script
            .then(response => response.json())
            .then(data => {
                // Update the HTML to display live scores
                const liveScoresContainer = document.getElementById('liveScoresContainer');
                liveScoresContainer.innerHTML = ''; // Clear previous content
                data.forEach(score => {
                    const scoreElement = document.createElement('div');
                    scoreElement.textContent = `${score.homeTeam} ${score.homeScore} - ${score.awayScore} ${score.awayTeam}`;
                    liveScoresContainer.appendChild(scoreElement);
                });
            })
            .catch(error => console.error('Error fetching live scores:', error));
    }

    // Fetch live scores initially
    fetchLiveScores();

    // Set interval to refresh live scores every 30 seconds
    setInterval(fetchLiveScores, 30000); // Adjust the interval as needed
});
