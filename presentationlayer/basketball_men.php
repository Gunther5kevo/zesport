<?php
include('../admin/includes/navbar.php')
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basketball Fixtures - ZeSport</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/football.css">
  
</head>
<body>
    
    <div class="container">
        <?php
        include('../datalayer/server.php');
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
            if ($action === 'standings' || $action === 'fixtures' || $action === 'results') {
                ?>
                <h2>Select Competition:</h2>
                <form id="competitionForm">
                    <div class="mb-3">
                        <label for="competition" class="form-label">Competition:</label>
                        <select class="form-select" id="competition" name="competition_id">
                            <?php 
                            // Fetch competitions based on gender
                            $gender = 'male';
                            $sql = "SELECT id, competition_name FROM basketballcompetitions WHERE gender = :gender";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute(['gender' => $gender]);
                            $competitions = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            
                            foreach ($competitions as $competition) {
                                echo '<option value="' . $competition['id'] . '">' . $competition['competition_name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </form>

                <div id="content"></div>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                <script>
                  $(document).ready(function() {
                    $('#competition').change(function() {
                        // Get the selected competition ID
                        var competitionId = $(this).val();
                        var gender = 'male'; // Set the gender here or retrieve it from the page

                        var action = '<?php echo $action; ?>'; 

                        $.ajax({
                            type: 'GET',
                            url: 'basketball_male_' + action + '.php', 
                            data: { competition_id: competitionId, gender: gender }, // Include gender parameter
                            success: function(response) {
                                $('#content').html(response); 
                            },
                            error: function(xhr, status, error) {
                                console.error('Error:', error); 
                            }
                            });
                        });

                        $("#competition").val($("#competition option:first").val()).change();
                    });

                </script>
                <?php
            } elseif ($action === 'news') {
                include('basketball_male_news.php');
            } else {
                include('basketball_male_standings.php');
            }
        } else {
            include('basketball_male_standings.php');
        }
        ?>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
