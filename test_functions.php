<?php
include 'user_functions.php';

// Create a new user with age
$newUserId = createUser('Yosof Kadase', 'ykadase@gmail.com', 25);
echo "New user created with ID: $newUserId\n";

// Read user information
$user = getUser($newUserId);
print_r($user);

// Update user information
updateUser($newUserId, 'Yosof Kadase', 'ykadase@gmail.com', 26);

// Read all users
$users = getAllUsers();
print_r($users);

// // Delete user
// deleteUser($newUserId);
// echo "User with ID $newUserId deleted\n";
?>
