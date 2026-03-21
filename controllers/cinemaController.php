<?php
include "../models/Cinema.php";
header("Content-Type: application/json");
$cinema=new Cinema();
$method=$_SERVER['REQUEST_METHOD'];
switch($method){
    case "POST":
        $data=json_decode(file_get_contents("php://input"),true);
        $name=$data['name'] ?? null;
        $location=$data['location']?? null;
        if(!$name || !$location){
            echo json_encode([
                "status"=>false,
                "message"=>"Không được bỏ trống!"
            ]);
            exit;
        }
        $check=$cinema->check($name);
        if($check->num_rows>0){
            echo json_encode([
                "status"=>false,
                "message"=>"Tên chi nhánh này đã tồn tại!"
                
            ]);
            exit;

        }
        $result=$cinema->create($name,$location);
        echo json_encode([
            "status"=>$result,
            "message"=>$result ? "Thêm chi nhánh mới thành công!":"Thêm thất bại!"
        ]);
        break;
    case "DELETE":
        $data=json_decode(file_get_contents("php://input"),true);
        $id=$data['id'];
        if(!$id){
            echo json_encode([
                "status"=>false,
                "message"=>"Thiếu id"
            ]);
            exit;

        }
        $found=$cinema->find($id);
        if($found->num_rows<=0){
            echo json_encode([
                "status"=>false,
                "message"=> "ID không tồn tại"
            ]);
            exit;

        }
        $result=$cinema->delete($id);
        echo json_encode([
            "status"=>$result,
            "message"=>$result? "Xóa thành công!":"Xóa thất bại!"
        ]);
        break;
    case "PUT":
        $data=json_decode(file_get_contents("php://input"),true);
        $name=$data['name'] ?? null;
        $location=$data['location']?? null;
        $id=$data['id'] ??null;
        if(!$id){
            echo json_encode([
                "status"=>false,
                "message"=>"Thiếu id"
            ]);
            exit;

        }
         $check=$cinema->check($name);
        if($check->num_rows>0){
            echo json_encode([
                "status"=>false,
                "message"=>"Tên chi nhánh này đã tồn tại!"
                
            ]);
            exit;

        }
         $found=$cinema->find($id);
        if($found->num_rows<=0){
            echo json_encode([
                "status"=>false,
                "message"=> "ID không tồn tại"
            ]);
            exit;

        }
        $result=$cinema->edit($id,$name,$location);
        echo json_encode([
            "status"=>$result,
            "message"=>$result? "Sửa thành công!":"Sửa thất bại!"
        ]);
        break;
    case "GET":
       
    $id = $_GET['id'] ?? null; 

    if ($id) {
        $result = $cinema->find($id);

        if ($result->num_rows <= 0) {
            echo json_encode([
                "status" => false,
                "message" => "Không tìm thấy cinema"
            ]);
            exit;
        }

        echo json_encode($result->fetch_assoc());
    } else {
        $result = $cinema->findAll();

        $list = [];
        while ($row = $result->fetch_assoc()) {
            $list[] = $row;
        }

        echo json_encode($list);
    }
    break;



    

}

?>