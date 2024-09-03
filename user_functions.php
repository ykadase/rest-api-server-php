<?php
include 'db.php';

// CREATE
function createUser($name, $email, $age) {
    $pdo = connect_db();
    $stmt = $pdo->prepare("INSERT INTO users (name, email, age) VALUES (:name, :email, :age)");
    $stmt->execute([':name' => $name, ':email' => $email, ':age' => $age]);
    return $pdo->lastInsertId();
}

// READ
function getUser($id) {
    $pdo = connect_db();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getAllUsers() {
    $pdo = connect_db();
    $stmt = $pdo->query("SELECT * FROM users");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// UPDATE
function updateUser($id, $name, $email, $age) {
    $pdo = connect_db();
    $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email, age = :age WHERE id = :id");
    return $stmt->execute([':id' => $id, ':name' => $name, ':email' => $email, ':age' => $age]);
}

// DELETE
function deleteUser($id) {
    $pdo = connect_db();
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    return $stmt->execute([':id' => $id]);
}
?>
