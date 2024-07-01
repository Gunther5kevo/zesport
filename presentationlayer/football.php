<?php include('../admin/includes/headerr.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Football Fixtures - ZeSport</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/football.css">
    <link rel="stylesheet" href="assets/css/contact.css">
    <style>
    .sidebar {
        background-color: #f8f9fa;
        padding: 15px;
        padding-top: 20px;
    }

    .sidebar ul {
        list-style-type: none;
        padding: 0;
    }

    .sidebar li {
        margin-bottom: 10px;
    }

    .nav-tabs {
        margin-top: 20px;
    }

    .tab-content {
        margin-top: 20px;
    }

    .tab-pane {
        padding: 20px;
    }

    .nav-link.active {
        font-weight: bold;
        background-color: #74759280;
    }
    </style>



<main>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 sidebar">
                <h2>Leagues and Tournaments</h2>
                <ul class="nav flex-column" id="competitionList">
                    <!-- Competition links will be dynamically populated here -->
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <div id="tabs">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="fixtures-tab" data-bs-toggle="tab" href="#fixtures"
                                role="tab" aria-controls="fixtures" aria-selected="true">Fixtures</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="results-tab" data-bs-toggle="tab" href="#results" role="tab"
                                aria-controls="results" aria-selected="false">Results</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="standings-tab" data-bs-toggle="tab" href="#standings" role="tab"
                                aria-controls="standings" aria-selected="false">Standings</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="fixtures" role="tabpanel"
                            aria-labelledby="fixtures-tab">
                            <!-- Fixture content will be loaded dynamically -->
                        </div>
                        <div class="tab-pane fade" id="results" role="tabpanel" aria-labelledby="results-tab">
                            <!-- Results content will be loaded dynamically -->
                        </div>
                        <div class="tab-pane fade" id="standings" role="tabpanel" aria-labelledby="standings-tab">
                            <!-- Standings content will be loaded dynamically -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>


<!-- Include necessary scripts for Bootstrap and jQuery -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    function fetchCompetitions() {
        $.ajax({
            type: 'GET',
            url: '../datalayer/fetch_competitions.php',
            success: function(response) {
                // console.log('Response:', response);  

                var competitions;
                if (typeof response === "object") {
                    competitions = response;
                } else {
                    try {
                        competitions = JSON.parse(response);
                    } catch (e) {
                        console.error("Parsing error:", e);
                        return;
                    }
                }

                var sidebarHtml = '';
                competitions.forEach(function(competition) {
                    sidebarHtml += '<li class="nav-item">';
                    sidebarHtml +=
                        '<a class="nav-link competition-link" data-competition-id="' +
                        competition.id + '" href="#">' + competition.competition_name +
                        '</a>';
                    sidebarHtml += '</li>';
                });
                $('#competitionList').html(sidebarHtml);

                // Attach click event listener to competition links
                $('.competition-link').click(function(e) {
                    e.preventDefault();
                    var competitionId = $(this).data('competition-id');

                    // Highlight the active competition
                    $('.competition-link').removeClass('active');
                    $(this).addClass('active');

                    loadCompetitionDetails(competitionId);
                });

                // Load details for the first competition by default
                if (competitions.length > 0) {
                    $('.competition-link').first().addClass('active');
                    loadCompetitionDetails(competitions[0].id);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching competitions:', error);
            }
        });
    }

    function loadCompetitionDetails(competitionId) {
        // Clear existing content
        $('#fixtures').empty();
        $('#results').empty();
        $('#standings').empty();

        // Load fixtures
        $.ajax({
            type: 'GET',
            url: '../datalayer/fetch_fixtures.php',
            data: {
                competition_id: competitionId
            },
            success: function(response) {
                // console.log('Fixtures Response:', response); 
                var fixtures;
                if (typeof response === "object") {
                    fixtures = response;
                } else {
                    try {
                        fixtures = JSON.parse(response);
                    } catch (e) {
                        console.error("Parsing error:", e);
                        return;
                    }
                }

                if (fixtures.message) {
                    $('#fixtures').html('<p>' + fixtures.message + '</p>');
                } else {
                    var fixturesHtml = '<table class="table table-striped">';
                    fixturesHtml +=
                        '<thead><tr><th>Date</th><th>Time</th><th>Home Team</th><th>Away Team</th><th>Venue</th><th>Referee</th></tr></thead>';
                    fixturesHtml += '<tbody>';

                    fixtures.forEach(function(fixture) {
                        fixturesHtml += '<tr>';
                        fixturesHtml += '<td>' + fixture.match_date + '</td>';
                        fixturesHtml += '<td>' + fixture.match_time + '</td>';
                        fixturesHtml += '<td>' + fixture.home_team + '</td>';
                        fixturesHtml += '<td>' + fixture.away_team + '</td>';
                        fixturesHtml += '<td>' + fixture.venue + '</td>';
                        fixturesHtml += '<td>' + fixture.referee + '</td>';
                        fixturesHtml += '</tr>';
                    });

                    fixturesHtml += '</tbody></table>';
                    $('#fixtures').html(fixturesHtml);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching fixtures:', error);
            }
        });

        // Load results
        $.ajax({
            type: 'GET',
            url: '../datalayer/fetch_results.php',
            data: {
                competition_id: competitionId
            },
            success: function(response) {
                // console.log('Results Response:', response); 
                var results;
                if (typeof response === "object") {
                    results = response;
                } else {
                    try {
                        results = JSON.parse(response);
                    } catch (e) {
                        console.error("Parsing error:", e);
                        return;
                    }
                }

                if (results.length === 0) {
                    $('#results').html('<p>No recent results found for this competition.</p>');
                } else {
                    var resultsHtml = '<table class="table table-striped">';
                    resultsHtml +=
                        '<thead><tr><th>Date</th><th>Home Team</th><th>Away Team</th><th>Score</th></tr></thead>';
                    resultsHtml += '<tbody>';

                    results.forEach(function(result) {
                        var homeTeam = result.home_team;
                        var awayTeam = result.away_team;
                        var homeScore = result.home_score !== null ? result.home_score :
                            '-';
                        var awayScore = result.away_score !== null ? result.away_score :
                            '-';
                        var score = (homeScore !== '-' && awayScore !== '-') ? homeScore +
                            ' - ' + awayScore : '-';

                        resultsHtml += '<tr>';
                        resultsHtml += '<td>' + result.match_date + '</td>';
                        resultsHtml += '<td>' + homeTeam + '</td>';
                        resultsHtml += '<td>' + awayTeam + '</td>';
                        resultsHtml += '<td>' + score + '</td>';
                        resultsHtml += '</tr>';
                    });

                    resultsHtml += '</tbody></table>';
                    $('#results').html(resultsHtml);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching results:', error);
            }
        });


        $.ajax({
            type: 'GET',
            url: '../datalayer/fetch_standings.php',
            data: {
                competition_id: competitionId
            },
            success: function(response) {
                // console.log('Standings Response:', response); 
                $('#standings').html(response); // Update standings tab content
            },
            error: function(xhr, status, error) {
                console.error('Error fetching standings:', error);
            }
        });
    }

    fetchCompetitions();
});
</script>
<footer>
<?php include('footer.php')?>
</footer>
</body>

</html>