<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basketball Standings</title>
    <style>
        #standings-table {
            width: 100%;
            border-collapse: collapse;
        }
        #standings-table th, #standings-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        #standings-table th {
            background-color: #f2f2f2;
            text-align: center;
        }
        #standings-table td {
            text-align: center;
        }
        #standings-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        #standings-table tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <h2>Basketball Standings</h2>
    <table id="standings-table">
        <thead>
            <tr>
                <th>Position</th>
                <th>Team</th>
                <th>Games Played</th>
                <th>Wins</th>
                <th>Losses</th>
                <th>Points For</th>
                <th>Points Against</th>
                <th>Win Percentage</th>
            </tr>
        </thead>
        <tbody>
            <!-- Standings data will be inserted here -->
        </tbody>
    </table>

    <script>
        async function fetchStandings() {
            try {
                const response = await fetch('path/to/your/php_script.php');
                const data = await response.json();
                
                const tableBody = document.querySelector('#standings-table tbody');
                tableBody.innerHTML = ''; // Clear any existing rows
                
                data.forEach(row => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${row.position}</td>
                        <td>${row.team_name}</td>
                        <td>${row.games_played}</td>
                        <td>${row.wins}</td>
                        <td>${row.losses}</td>
                        <td>${row.points_for}</td>
                        <td>${row.points_against}</td>
                        <td>${(row.win_percentage * 100).toFixed(1)}%</td>
                    `;
                    tableBody.appendChild(tr);
                });
            } catch (error) {
                console.error('Error fetching standings:', error);
            }
        }

        // Fetch standings when the page loads
        window.onload = fetchStandings;
    </script>
</body>
</html>
