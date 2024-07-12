document.addEventListener('DOMContentLoaded', function() {
    let currentIndex = 0; 
    const maxIndex = 4; 

    // Function to fetch live scores from the server
    function fetchLiveScores() {
        fetch('../datalayer/fetch_live_scores.php') 
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                const liveScoresContainer = document.getElementById('liveScoresContainer');
                liveScoresContainer.innerHTML = ''; // Clear previous content

                // Check if data is valid and not empty
                if (data && data.length > 0) {
                    // Ensure currentIndex is within valid range
                    currentIndex = currentIndex % data.length;
                    // Display up to 5 live scores
                    for (let i = 0; i <= maxIndex && i < data.length; i++) {
                        const index = (currentIndex + i) % data.length;
                        const score = data[index];
                        const li = document.createElement('li');
                        li.textContent = `${score.homeTeam} ${score.homeScore} - ${score.awayScore} ${score.awayTeam}`;
                        liveScoresContainer.appendChild(li);
                    }
                    // Increment currentIndex for next rotation
                    currentIndex = (currentIndex + 1) % data.length;
                } else {
                    console.log('No live scores available');
                }
            })
            .catch(error => {
                console.error('Error fetching live scores:', error);
            });
    }

    
    fetchLiveScores();

    
    setInterval(fetchLiveScores, 30000); // Adjust the interval as needed
});
