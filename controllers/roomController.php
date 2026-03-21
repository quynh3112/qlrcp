<?php
include "../config/db.php";
include "../models/Room.php";

header("Content-Type: application/json");

$method = $_SERVER["REQUEST_METHOD"];

$room = new Room();
$seats=new Seats();

switch ($method) {
    case "POST":

        $data = json_decode(file_get_contents("php://input"), true);


        if (
            !isset($data["theater_name"]) ||
            !isset($data["total_seats"]) ||
            !isset($data["cinema_id"]) ||
            !isset($data["type"])
        ) {
            echo json_encode([
                "status" => false,
                "message" => "Thiếu dữ liệu"
            ]);
            exit;
        }
        $check=$room->check($cinema_id,$name);
        if($check->num_rows<0){
            echo json_encode([
                "status"=>false,
                "message"=>"Phòng đã tồn tại trên hệ thống!"
            ]);
            exit;

        }

        $name = $data["theater_name"];
        $total_seats = $data["total_seats"];
        $cinema_id = $data["cinema_id"];
        $type = $data["type"];

        $result = $room->create($name, $total_seats, $cinema_id, $type);

        echo json_encode($result);
        break;
    case "DELETE":
        $data=json_decode(file_get_contents("php://input"),true);
        $id=$data['theater_id'];
        if(!$id){
            echo json_encode([
                "status"=>false,
                "message"=>"Thiếu id"
            ]);

         
        }
        $check=$room->find($id);
        if($check->num_rows==0){
             echo json_encode([
                "status"=>false,
                "message"=>"Id phòng không tồn tại"
            ]);
           exit;
        }
        
        $result=$room->delete($id);
        json_encode($result);
        break;
    case "GET":
       $id=$_GET['id'] ?? null;
       if($id){
        $result=$room->find($id);
        echo json_encode($result);

       }
       else{
        $result=$room->findAll();
        $list=[];
        while($row=$result->fetch_assoc()){
            $list=$row;

        }
        echo json_encode($list);
       }

}
?>