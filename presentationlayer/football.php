<?php include('../admin/includes/headerr.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Football Fixtures - ZeSport</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
</head>

<body>


    <main>
        <section id="title" class="turquoise">
            <div class="container">
                <div class="title_row">
                    <div class="pull-right">
                        <h1 class="animate-flicker4 animated pulse">
                            <img src="assets/img/football-logo.png" alt="Football Logo"> Football
                        </h1>
                    </div>
                </div>
            </div>
        </section>

        <div class="container-fluid">
            <div class="row">
                <!-- Season Filter -->
                <div class="col-md-3 sidebar">
                    <h2>Seasons</h2>
                    <select class="form-select mb-3" id="seasonFilter">
                        <!-- Season options will be dynamically populated here -->
                    </select>

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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
    $(document).ready(function() {
        // Function to fetch seasons
        function fetchSeasons() {
            $.ajax({
                type: 'GET',
                url: '../datalayer/fetch_seasons.php',
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        console.error('Error fetching seasons:', response.error);
                        return;
                    }

                    var seasons = response;
                    var seasonOptions = '';
                    seasons.forEach(function(season) {
                        seasonOptions += '<option value="' + season.id + '">' + season
                            .season + '</option>';
                    });
                    $('#seasonFilter').html(seasonOptions);

                    // Attach change event listener to season filter
                    $('#seasonFilter').change(function() {
                        var selectedSeason = $(this).val();
                        fetchCompetitions(
                        selectedSeason); // Call fetchCompetitions with selected season
                    });

                    // Load competitions for the default season on page load
                    var defaultSeason = $('#seasonFilter').val();
                    fetchCompetitions(defaultSeason);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching seasons:', error);
                }
            });
        }

        // Function to fetch competitions based on season
        function fetchCompetitions(seasonId) {
            $.ajax({
                type: 'GET',
                url: '../datalayer/fetch_competitions.php',
                data: {
                    season: seasonId // Pass seasonId as 'season' parameter
                },
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        console.error('Error fetching competitions:', response.error);
                        return;
                    }

                    var sidebarHtml = '';
                    response.forEach(function(competition) {
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
                    if (response.length > 0) {
                        $('.competition-link').first().addClass('active');
                        loadCompetitionDetails(response[0].id);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching competitions:', error);
                }
            });
        }

        // Function to load competition details (fixtures, results, standings)
        function loadCompetitionDetails(competitionId) {
            var seasonId = $('#seasonFilter').val(); // Get the selected season ID

            // Clear existing content
            $('#fixtures').empty();
            $('#results').empty();
            $('#standings').empty();

            // Fetch fixtures
            $.ajax({
                type: 'GET',
                url: '../datalayer/fetch_fixtures.php',
                data: {
                    competition_id: competitionId,
                    season_id: seasonId // Pass seasonId to fetch fixtures for the selected season
                },
                dataType: 'json',
                success: function(response) {
                    try {
                        if (response.error) {
                            console.error('Error fetching fixtures:', response.error);
                            $('#fixtures').html('<p>Error fetching fixtures: ' + response.error +
                                '</p>');
                            return;
                        }

                        if (response.message) {
                            $('#fixtures').html('<p>' + response.message + '</p>');
                        } else {
                            var tableHtml =
                                '<table class="table table-bordered"><thead><tr><th>Date</th><th>Time</th><th>Home Team</th><th>Away Team</th><th>Venue</th><th>Referee</th></tr></thead><tbody>';
                            response.forEach(function(fixture) {
                                tableHtml += '<tr><td>' + fixture.match_date + '</td><td>' +
                                    fixture.match_time + '</td><td>' + fixture.home_team +
                                    '</td><td>' + fixture.away_team + '</td><td>' + fixture
                                    .venue + '</td><td>' + fixture.referee + '</td></tr>';
                            });
                            tableHtml += '</tbody></table>';
                            $('#fixtures').html(tableHtml);
                        }
                    } catch (error) {
                        console.error('Error handling response:', error);
                        $('#fixtures').html(
                            '<p>Error handling response. Please try again later.</p>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    $('#fixtures').html('<p>Error fetching fixtures. Please try again later.</p>');
                }
            });

            // Fetch results
            $.ajax({
                type: 'GET',
                url: '../datalayer/fetch_results.php',
                data: {
                    competition_id: competitionId,
                    season_id: seasonId // Pass seasonId to fetch results for the selected season
                },
                dataType: 'json',
                success: function(response) {
                    try {
                        if (response.error) {
                            console.error('Error fetching results:', response.error);
                            $('#results').html('<p>Error fetching results: ' + response.error +
                                '</p>');
                        } else if (response.length > 0) {
                            var resultsHtml = '<table class="table table-striped">';
                            resultsHtml +=
                                '<thead><tr><th>Date</th><th>Home Team</th><th>Away Team</th><th>Score</th></tr></thead><tbody>';
                            response.forEach(function(result) {
                                resultsHtml += '<tr>';
                                resultsHtml += '<td>' + result.match_date + '</td>';
                                resultsHtml += '<td>' + result.home_team + '</td>';
                                resultsHtml += '<td>' + result.away_team + '</td>';
                                resultsHtml += '<td>' + (result.home_score !== null ? result
                                    .home_score : '-') + ' - ' + (result.away_score !==
                                    null ? result.away_score : '-') + '</td>';
                                resultsHtml += '</tr>';
                            });
                            resultsHtml += '</tbody></table>';
                            $('#results').html(resultsHtml);
                        } else {
                            $('#results').html('<p>No results found for this competition.</p>');
                        }
                    } catch (error) {
                        console.error('Error handling response:', error);
                        $('#results').html(
                            '<p>Error handling response. Please try again later.</p>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching results:', error);
                    $('#results').html('<p>Error fetching results. Please try again later.</p>');
                }
            });

            // Fetch standings
            $.ajax({
                type: 'GET',
                url: '../datalayer/fetch_standings.php',
                data: {
                    competition_id: competitionId,
                    season_id: seasonId // Pass seasonId to fetch standings for the selected season
                },
                success: function(response) {
                    $('#standings').html(response); // Update standings tab content
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching standings:', error);
                    $('#standings').html(
                    '<p>Error fetching standings. Please try again later.</p>');
                }
            });
        }

        // Initialize the page
        fetchSeasons();
    });
    </script>

    <?php include('footer.php'); ?>
</body>

</html>