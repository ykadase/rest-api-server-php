<?php
header("Content-Type: application/json");

include 'user_functions.php';

// Get the HTTP method
$method = $_SERVER['REQUEST_METHOD'];
// Get the full request URI
$requestUri = $_SERVER['REQUEST_URI'];
// echo "requestUri:".$requestUri."<br>";

// Remove query string from URI if present
$requestUri = strtok($requestUri, '?');
// echo "requestUri:".$requestUri."<br>";

// Assuming your script is located in /api, remove the base path
// $scriptName = str_replace('/myapi', '', $requestUri);
$scriptName = str_replace('/api', '', $requestUri);
// echo "scriptName:".$scriptName;

$request_data = explode('/', trim($scriptName, '/'));
// echo "request_data:".$request_data."<br>";
// var_dump($request_data);


$resource = array_shift($request_data);
// echo "resource:".$resource;


$id = array_shift($request_data);
// echo "id:".$id;


// Handle requests based on method and resource
switch ($method) {
    case 'GET':
        if ($resource === 'users') {
            if ($id) {
                $user = getUser($id);
                if ($user) {
                    echo json_encode($user);
                } else {
                    http_response_code(404);
                    echo json_encode(["message" => "User not found"]);
                }
            } else {
                $users = getAllUsers();
                echo json_encode($users);
            }
        }
        break;

    case 'POST':
        if ($resource === 'users') {
            $data = json_decode(file_get_contents('php://input'), true);
            if (isset($data['name'], $data['email'], $data['age'])) {
                $newUserId = createUser($data['name'], $data['email'], $data['age']);
                http_response_code(201);
                echo json_encode(["message" => "User created", "id" => $newUserId]);
            } else {
                http_response_code(400);
                echo json_encode(["message" => "Invalid input"]);
            }
        }
        break;

    case 'PUT':
        if ($resource === 'users' && $id) {
            $data = json_decode(file_get_contents('php://input'), true);
            if (isset($data['name'], $data['email'], $data['age'])) {
                $updated = updateUser($id, $data['name'], $data['email'], $data['age']);
                if ($updated) {
                    echo json_encode(["message" => "User updated"]);
                } else {
                    http_response_code(404);
                    echo json_encode(["message" => "User not found"]);
                }
            } else {
                http_response_code(400);
                echo json_encode(["message" => "Invalid input"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Invalid request"]);
        }
        break;

    case 'DELETE':
        if ($resource === 'users' && $id) {
            $deleted = deleteUser($id);
            if ($deleted) {
                echo json_encode(["message" => "User deleted"]);
            } else {
                http_response_code(404);
                echo json_encode(["message" => "User not found"]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Invalid request"]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["message" => "Method not allowed"]);
        break;
}
?>
