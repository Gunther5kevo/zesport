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
    } else {
        
        echo '<div class="alert alert-info">
        <h6>No status message found.</h6>
        </div>';
    }
}


function checkParamId($paramType){
    if(isset($_GET[$paramType])){
        return $_GET[$paramType];
    }else{
        return 'No id given';
    }
}

function getById($pdo, $tableName, $id){
    
    $table = validate($tableName);
    $id = validate($id);

    $query = "SELECT * FROM $table WHERE id = :id LIMIT 1";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $id]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result; // Return the result or false if no result found
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
