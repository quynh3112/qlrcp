<?php
header("Content-Type: application/json");
require_once "../config/db.php";
require_once "../models/Room.php";

$method = $_SERVER['REQUEST_METHOD'];

$seats = new Seats();
$room = new Room();

switch ($method) {

    case "GET":

        $id = $_GET['theater_id'] ?? null;

        if ($id === null) {
            echo json_encode([
                "status" => false,
                "message" => "Thiếu theater_id"
            ]);
            exit;
        }

        $check = $room->find($id); 

        if (!$check) {
            echo json_encode([
                "status" => false,
                "message" => "Phòng không tồn tại!"
            ]);
            exit;
        }

        $result = $seats->findAll($id);

        echo json_encode($result);

        break;
}
?>