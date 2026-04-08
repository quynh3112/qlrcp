<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . "/../controllers/theaters.php";
$controller = new TheaterController($conn);
$method = $_SERVER['REQUEST_METHOD'];
switch($method){
    case "GET":
        if(isset($_GET['id'])){
            $controller->getById($_GET['id']);
        } else {
            $controller->getAll();
        }
        break;
    case "POST":
        $controller->create();
        break;
    case "PUT":
        $controller->update();
        break;
    case "DELETE":
        $controller->delete();
        break;
}
?>