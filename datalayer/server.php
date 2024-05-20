<?php

$host = 'localhost';
$username = 'root';
$password = 'kevo123';
$database = 'zesportdb';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
} catch (PDOException $e) {
    die("Database connection or thumbnail generation error: " . $e->getMessage());
}

?>
