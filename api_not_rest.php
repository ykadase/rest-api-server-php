<?php
header("Content-Type: application/json");

include 'user_functions.php';

// Get the HTTP method
$method = $_SERVER['REQUEST_METHOD'];
// echo "method:".$method;

$requestURI=$_SERVER['REQUEST_URI'];
// echo "requestURI:".$requestURI;
var_dump($requestURI);

$clean_requestURI=str_replace('/api', '', $requestURI);
// echo "$clean_requestURI:".$clean_requestURI;

// var_dump($clean_requestURI);

// echo "PATH:".$_SERVER['PATH_INFO'];
// echo $_SERVER['REQUEST_URI'];
// Get the path info to determine the action (e.g., /users/1)
// $request = explode('/', trim($_SERVER['PATH_INFO'], '/'));


// $request = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
// echo $request;
// var_dump($request);

// $scriptName = str_replace('/api', '', $request);
// echo "clean_request:".$clean_request;

// The first element is the resource, and the second is the ID (if any)
$resource = array_shift($$clean_requestURI);
echo $resource;

$id = array_shift($request);

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
