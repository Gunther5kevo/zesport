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



?>