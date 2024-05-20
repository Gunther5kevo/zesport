
<?php

// Load environment variables from .env file
$dotenv = parse_ini_file('../.env');

$host = $dotenv['host'];
$username = $dotenv['username'];
$password = $dotenv['password'];
$database = $dotenv['database'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Database connection or thumbnail generation error: " . $e->getMessage());
}

?>
