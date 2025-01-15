<?php
header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Method: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: X-Requested-With");
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header("Content-Type: application/json");


require_once('inv-api/controller/API.php');

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


            $requestUri = $_SERVER['REQUEST_URI'] ?? '';
            $requestUri = trim($requestUri);

            $uriParts = explode('/', trim($requestUri, '/'));


            if (isset($uriParts[2])) {
                $id = $uriParts[2];
            } else {
                $id = null;
            }

            
            $response = $controller->listBillUser($id);
        } else {
            $response = ['error' => 'Invalid request method'];
        }
        break;


    case 'listBillAdmin':
        if ($requestMethod === 'GET') {


            $requestUri = $_SERVER['REQUEST_URI'] ?? '';
            $requestUri = trim($requestUri);

            $uriParts = explode('/', trim($requestUri, '/'));


            if (isset($uriParts[2])) {
                $org = urldecode($uriParts[2]);
            } else {
                $org = null;
            }

            
            $response = $controller->listBillAdmin($org);
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
            if ($requestMethod === 'GET') {


            $requestUri = $_SERVER['REQUEST_URI'] ?? '';
            $requestUri = trim($requestUri);

            $uriParts = explode('/', trim($requestUri, '/'));


            if (isset($uriParts[2])) {
                $org = urldecode($uriParts[2]);
            } else {
                $org = null;
            }

            
            $response = $controller->listDelete($org);
        } else {
            $response = ['error' => 'Invalid request method'];
        }
        break;

    case 'listUser':
         if ($requestMethod === 'GET') {


            $requestUri = $_SERVER['REQUEST_URI'] ?? '';
            $requestUri = trim($requestUri);

            $uriParts = explode('/', trim($requestUri, '/'));


            if (isset($uriParts[2])) {
                $org = urldecode($uriParts[2]);
            } else {
                $org = null;
            }

            
            $response = $controller->listUser($org);
        } else {
            $response = ['error' => 'Invalid request method'];
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

    case 'listOrganize':
        if ($requestMethod === 'GET') {
            $response = $controller->listOrganize();
        } else {
            $response = ['error' => 'invalid request method'];
        }
        break;

    case 'listPosition':
        if ($requestMethod === 'GET') {
            $response = $controller->listPosition();
        } else {
            $response = ['error' => 'invalid request method'];
        }
        break;

case 'listBtnStatus':
        if ($requestMethod === 'GET') {
            
            $requestUri = $_SERVER['REQUEST_URI'] ?? '';
            $requestUri = trim($requestUri);

            $uriParts = explode('/', trim($requestUri, '/'));


            if (isset($uriParts[2])) {
                $org = urldecode($uriParts[2]);
            } else {
                $org = null;
            }

            $response = $controller->listBtnStatus($org);
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
