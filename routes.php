<?php

//import get and post files
require_once "./config/database.php";
require_once "./modules/Get.php";
require_once "./modules/Post.php";
require_once "./modules/Patch.php";
require_once "./modules/Delete.php";
require_once "./modules/Auth.php";
require_once "./modules/Crypt.php";

$db = new Connection();
$pdo = $db->connect();

//instantiate post, get class
$post = new Post($pdo);
$patch = new Patch($pdo);
$get = new Get($pdo);
$delete = new Delete($pdo);
$auth = new Authentication($pdo);
$crypt = new Crypt();

//retrieved and endpoints and split
if(isset($_REQUEST['request'])){
    $request = explode("/", $_REQUEST['request']);
}
else{
    echo "URL does not exist.";
}

//get post put patch delete etc
//Request method - http request methods you will be using

switch($_SERVER['REQUEST_METHOD']){

    case "GET":
        if($auth->isAuthorized()){
        switch($request[0]){

            case "shows":
                $dataString = json_encode($get->getShows($request[1] ?? null));
                echo $crypt->encryptData($dataString);
            break;

            case "channel":
                $dataString = json_encode($get->getChannel($request[1] ?? null));
                echo $crypt->encryptData($body);
            break;

            case "log";
                echo json_encode($get->getLogs($request[1] ?? date("Y-m-d")));
            break;
            

            default:
                http_response_code(401);
                echo "This is invalid endpoint";
            break;
        }
    }
    else {
        echo "Unauthorized";
    }

    break;


    case "POST":
        $body = json_decode(file_get_contents("php://input"));
        switch($request[0]){
            case "login":
                echo json_encode($auth->login($body));
            break;
            
            case "user":
                echo json_encode($auth->addAccount($body));
            break;

            case "shows":
                echo $crypt->decryptData($body);
            break;

            case "channel":
                echo json_encode($post->postChannel($body));
            break;

            default:
                http_response_code(401);
                echo "This is invalid endpoint";
            break;
        }
    break;


    case "PATCH":
        $body = json_decode(file_get_contents("php://input"));
        switch($request[0]){
            case "shows":
                echo json_encode($patch->patchShows($body, $request[1]));
                break;
        }
    break;

    case "DELETE":
        switch($request[0]){
            case "shows":
                echo json_encode($patch->archiveShows($request[1]));
            break;
        }
        case "destroyshows":
            echo json_encode($delete->deleteShows($request[1]));
            break;
    break;    

    default:
        http_response_code(400);
        echo "Invalid Request Method.";
    break;
}



?>