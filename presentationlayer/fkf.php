<?php
require_once '../vendor/autoload.php';

// Use the HTML DOM Parser
use Sunra\PhpSimple\HtmlDomParser;

// URL of the FKF Women Premier League standings page
$url = "https://footballkenya.org/competitions/fkf-women-premier-league/";

try {
    // Get the HTML content from the URL
    $html_content = file_get_contents($url);

    if ($html_content === false) {
        throw new Exception("Failed to fetch HTML content.");
    }

    // Create a DOM object
    $html = HtmlDomParser::str_get_html($html_content);

    // Check if the HTML was successfully loaded
    if ($html === false) {
        throw new Exception("Failed to parse HTML content.");
    }

    // Apply CSS styles for the whole document
    echo <<<CSS
    <style>
        body {
            background-color: #EEF7FF;
            color: #333;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 8px;
        }
        th {
            background-color: #3a87ad;
        }
        .highlight-row td {
            background-color: #d67900;
            color: #fff;
        }
    </style>
    CSS;

    // Find the table containing the standings
    $table = $html->find('table', 1); // Assuming the table is the second table in the page

    if ($table) {
        echo "<h1>FKF Women Premier League Standings</h1>";
        echo "<table>";

        // Extract rows
        foreach ($table->find('tr') as $index => $row) {
            // Skip the header row
            if ($index === 0) {
                echo "<tr>";
                foreach ($row->find('th') as $th) {
                    echo "<th>" . $th->plaintext . "</th>";
                }
                echo "</tr>";
                continue;
            }

            // Highlight Zetech Sparks team and mark the row
            $team_name = $row->find('td', 1)->plaintext; // Assuming the team name is in the second column
            $highlight_class = ($team_name === 'Zetech Sparks FC') ? 'highlight-row' : '';

            echo "<tr class='$highlight_class'>";
            foreach ($row->find('td') as $cell) {
                echo "<td>" . $cell->plaintext . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Standings table not found.";
    }
} catch (Exception $e) {
    echo "An error occurred: " . $e->getMessage();
}
?>
