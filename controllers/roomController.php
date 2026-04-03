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
         $name = $data["theater_name"];
        $total_seats = $data["total_seats"];
        $cinema_id = $data["cinema_id"];
        $type = $data["type"];
        $check=$room->check($cinema_id,$name);
        if($check->num_rows>0){
            echo json_encode([
                "status"=>false,
                "message"=>"Phòng đã tồn tại trên hệ thống!"
            ]);
            exit;

        }

       

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
       $id=$_GET['cinema_id'] ?? null;
       if($id){
        $result=$room->find($id);
        if($result->num_rows==0){
            echo json_encode([
                "status"=>false,
                "message"=>"Chưa có phòng nào thuộc rạp này"
            ]);
           exit;
        }
        $list=[];
        while($row=$result->fetch_assoc()){
            $list[]=$row;

        }
        echo json_encode($list);
       

       }
       else{
        $result=$room->findAll();
        $list=[];
        while($row=$result->fetch_assoc()){
            $list[]=$row;

        }
        echo json_encode($list);
       }
        break;

    case "PUT":
    $data = json_decode(file_get_contents("php://input"), true);

    if(!$data){
        echo json_encode([
            "status"=>false,
            "message"=>"Dữ liệu không hợp lệ"
        ]);
        exit;
    }

    $id = $data['theater_id'];
    $cinema_id = $data['cinema_id'];
    $name = $data['theater_name'];
    $total_seats = $data['total_seats'];
    $type = $data['type'];

    if(
        !isset($id) || 
        !isset($cinema_id) || 
        !isset($name) || 
        !isset($total_seats) || 
        !isset($type)
    ){
        echo json_encode([
            "status"=>false,
            "message"=>"Thiếu dữ liệu"
        ]);
        exit;
    }

    $check = $room->findById($id);
    if(!$check){
        echo json_encode([
            "status"=>false,
            "message"=>"Phòng không tồn tại"
        ]);
        exit;
    }

    $result = $room->edit($id,$cinema_id,$name,$total_seats,$type);

    echo json_encode([
        "status"=>$result,
        "message"=>$result?"Sửa phòng thành công":"Lỗi sửa phòng"
    ]);

}
?>