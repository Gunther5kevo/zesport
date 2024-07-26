<?php include('includes/header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }

        .background-span {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            z-index: -1; /* Ensure the span is behind other content */
        }

        .content {
            position: relative;
            z-index: 1; /* Ensure the content is above the background image */
        }

        .metric-card {
            background-color: #f8f9fa;
            border-radius: 0.375rem;
            padding: 1rem;
            text-align: center;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .metric-card h5 {
            margin-bottom: 0.5rem;
        }

        .metric-card .value {
            font-size: 2rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    
    <div class="container content">
        <div class="row">
            <!-- Search Bar -->
            <div class="col-md-12 mb-4">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for matches, teams, or players..." aria-label="Search" aria-describedby="search-button">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button" id="search-button">Search</button>
                    </div>
                </div>
            </div>

            <!-- Metrics Cards -->
            <div class="col-md-4 mb-4">
                <div class="metric-card">
                    <h5>Total Matches</h5>
                    <div class="value" id="totalMatches">Loading...</div>
                </div>
            </div>
            
            </div>
            <div class="col-md-4 mb-4">
                <div class="metric-card">
                    <h5>Upcoming Fixtures</h5>
                    <div class="value" id="upcomingFixtures">Loading...</div>
                </div>
            </div>

            <!-- Latest Matches -->
            <div class="col-md-12 mb-4">
                <div class="card card-body">
                    <h5 class="font-weight-bolder">Latest Matches</h5>
                    <table class="table table-striped" id="latestMatches">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Match</th>
                                <th>Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Latest matches will be dynamically populated here -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Upcoming Matches -->
            <div class="col-md-12 mb-4">
                <div class="card card-body">
                    <h5 class="font-weight-bolder">Upcoming Matches</h5>
                    <ul class="list-group" id="upcomingMatchesList">
                        <!-- Upcoming matches will be dynamically populated here -->
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="dashboard.js"></script>
</body>
</html>
<?php include('includes/footer.php'); ?>
