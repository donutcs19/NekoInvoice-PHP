<?php
header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Method: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: X-Requested-With");
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header("Content-Type: application/json");


require_once('controller/API.php');

$requestMethod = $_SERVER['REQUEST_METHOD'];
$controller = new API();


$path = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
$action = isset($path[1]) ? $path[1] : '';

$data = json_decode(file_get_contents('php://input'), true);

switch ($action) {

    case '':
        echo "Hello NekoCat BIll";
        break;

    case 'create':
        if ($requestMethod === 'POST') {
            $response = $controller->create($data);
        } else {
            $response = ['error' => 'Invalid request method'];
        }
        break;

    case 'deleteBill':
        if ($requestMethod === 'PUT') {
            $response = $controller->deleteBill($data);
        } else {
            $response = ['error' => 'Invalid request method'];
        }
        break;

    case 'listBillUser':
        if ($requestMethod === 'GET') {
            $response = $controller->listBillUser();
        } else {
            $response = ['error' => 'Invalid request method'];
        }
        break;


    case 'listBillAdmin':
        if ($requestMethod === 'GET') {
            $response = $controller->listBillAdmin();
        } else {
            $response = ['error' => 'Invalid request method'];
        }
        break;

    case 'updateStatus':
        if ($requestMethod === 'PUT') {
            $response = $controller->updateStatus($data);
        } else {
            $response = ['error' => 'Invalid request method'];
        }
        break;

        case 'listDelete':
            if($requestMethod === 'GET'){
                $response = $controller->listDelete();
            }else{
                $response = ['error' => 'invalid request method'];
            }

            case 'listUser':
        if ($requestMethod === 'GET') {
            $response = $controller->listUser();
        } else {
            $response = ['error' => 'invalid request method'];
        }
        break;

    case 'updateRole':
        if ($requestMethod === 'PUT') {
            $response = $controller->updateRole($data);
        } else {
            $response = ['error' => 'Invalid request method'];
        }
        break;

    case 'disableUser':
        if ($requestMethod === 'PUT') {
            $response = $controller->disableUser($data);
        } else {
            $response = ['error' => 'Invalid request method'];
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(['error' => 'Action not found']);
        break;
}

if (isset($response)) {
    echo json_encode($response);
}
