<?php
function connect_db() {
    $host = 'localhost';
    $dbname = 'user_management';
    $username = 'root';  // replace with your MySQL username
    $password = '';      // replace with your MySQL password

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        exit;
    }
}
?>
