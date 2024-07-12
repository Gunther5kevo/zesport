<?php
session_start();
include('../datalayer/server.php');

function validate($inputData){
    // No need to use global $conn in PDO
    // Just trim the input data
    return trim($inputData);
}

function redirect($url, $status){
    $_SESSION['status'] = $status;
    header('Location: '.$url);
    exit(0);
}

function alertMessage()
{
    if(isset($_SESSION['status'])){
        echo '<div class="alert alert-success">
        <h6>'.$_SESSION['status'].'</h6>
        </div>';
        unset($_SESSION['status']);
    } 

}

function logoutSession(){
    unset($_SESSION ['auth']);
    unset($_SESSION ['loggedInUserRole']);
    unset($_SESSION ['loggedInUser']);
}


function checkParamId($paramType){
    if(isset($_GET[$paramType])){
        return $_GET[$paramType];
    }else{
        return 'No id given';
    }
}


function deleteQuery($pdo, $tableName, $id) {

    
    $table = validate($tableName);
    $id = validate($id);

    try {
        $query = "DELETE FROM $table WHERE id = :id LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {      
        return false;
    }
}


function getById($pdo, $tableName, $id) {
    
    $table = validate($tableName);
    $id = validate($id);

    try {
        $query = "SELECT * FROM $table WHERE id = :id LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $response = [
                'status' => 200,
                'data' => $result
            ];
        } else {
            $response = [
                'status' => 404,
                'message' => 'No Data Record'
            ];
        }
        return $response;

    } catch (PDOException $e) {
        
        $response = [
            'status' => 500,
            'message' => 'Something Went Wrong: ' . $e->getMessage()
        ];
        return $response;
    }
}




function getAll($pdo, $tableName) {
    
    $table = validate($tableName);

    $query = "SELECT * FROM $table";
    $stmt = $pdo->query($query);

    if ($stmt) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return false;
    }
}





function generateCompetitionForm($sport, $formAction) {
    // Include server.php for database connection and functions
    include('../datalayer/server.php');
    
    // Determine gender options based on sport
    if ($sport === 'football') {
        $genderOptions = '
            <option value="male">Male</option>
            <option value="female">Female</option>
        ';
    } elseif ($sport === 'basketball' || $sport === 'rugby') {
        $genderOptions = '
            <option value="male">Male</option>
            <option value="female">Female</option>
        ';
    } else {
        // Handle any other sport or invalid input gracefully
        die('Invalid sport type');
    }
    
    try {
        // Fetch seasons from the database
        $seasonQuery = "SELECT id, season FROM seasons ORDER BY season";
        $stmtSeason = $pdo->query($seasonQuery);
        $seasonOptions = '';
        
        while ($row = $stmtSeason->fetch(PDO::FETCH_ASSOC)) {
            $seasonOptions .= '<option value="' . $row['id'] . '">' . htmlspecialchars($row['season']) . '</option>';
        }
    } catch (PDOException $e) {
        // Handle database error
        die('Database error: ' . $e->getMessage());
    }
    
    // Generate the form HTML
    echo '
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <?= alertMessage(); ?>
                    <h4>Create New ' . ucfirst($sport) . ' Tournament</h4>
                    <form method="post" action="' . $formAction . '">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="competition" class="form-label">Competition Name:</label>
                                <input type="text" id="competition" name="competition" class="form-control" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="gender" class="form-label">Gender:</label>
                                <select id="gender" name="gender" class="form-select" required>
                                    ' . $genderOptions . '
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="season" class="form-label">Season:</label>
                                <select id="season" name="season" class="form-select" required>
                                    <option value="">Select Season</option>
                                    ' . $seasonOptions . '
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" name="create_competition">Create Tournament</button>
                    </form>
                </div>
            </div>
        </div>
    ';
}






