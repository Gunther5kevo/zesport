$(document).ready(function() {
    // Fetch metrics
    function fetchMetrics() {
        $.ajax({
            type: 'GET',
            url: '../datalayer/fetch_metrics.php',
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    console.error('Error fetching metrics:', response.error);
                    return;
                }

                $('#totalMatches').text(response.totalMatches || 'N/A');
                $('#upcomingFixtures').text(response.upcomingFixtures || 'N/A');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching metrics:', status, error);
            }
        });
    }

    // Fetch latest matches
    function fetchLatestMatches() {
        $.ajax({
            type: 'GET',
            url: '../datalayer/fetch_results.php',
            dataType: 'json',
            data: {
                competition_id: 1,
                season_id: 1
            },
            success: function(response) {
                if (response.error) {
                    console.error('Error fetching latest matches:', response.error);
                    return;
                }

                if (Array.isArray(response)) {
                    const latestMatchesHtml = response.map(match => 
                        `<tr><td>${match.match_date}</td><td>${match.home_team} vs ${match.away_team}</td><td>${match.home_score || 'N/A'}-${match.away_score || 'N/A'}</td></tr>`
                    ).join('');
                    $('#latestMatches tbody').html(latestMatchesHtml);
                } else {
                    console.error('Unexpected response format for latest matches:', response);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching latest matches:', status, error);
            }
        });
    }

    // Fetch upcoming matches
    function fetchUpcomingMatches() {
        $.ajax({
            type: 'GET',
            url: '../datalayer/fetch_fixtures.php',
            dataType: 'json',
            data: {
                competition_id: 1, // Example competition ID
                season_id: 1 // Example season ID
            },
            success: function(response) {
                if (response.error) {
                    console.error('Error fetching upcoming matches:', response.error);
                    return;
                }
    
                if (Array.isArray(response)) {
                    const upcomingMatchesHtml = response.map(match => 
                        `<li class="list-group-item">${match.match_date} - ${match.home_team} vs ${match.away_team}</li>`
                    ).join('');
                    $('#upcomingMatchesList').html(upcomingMatchesHtml);
                } else {
                    console.error('Unexpected response format for upcoming matches:', response);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching upcoming matches:', status, error);
            }
        });
    }
    
   
    

    // Initialize the dashboard
    fetchMetrics();
    fetchLatestMatches();
    fetchUpcomingMatches();
});
