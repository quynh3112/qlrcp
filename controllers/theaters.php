<?php
header("Content-Type: application/json");

include "../config/db.php";
include "../models/theaters.php";

$theater = new Theater($conn);
$method = $_SERVER['REQUEST_METHOD'];

switch($method){

    // 🔍 LẤY DANH SÁCH
    case "GET":
        $result = $theater->getAll();

        $list = [];
        while($row = $result->fetch_assoc()){
            $list[] = $row;
        }

        echo json_encode([
            "status" => true,
            "data" => $list
        ]);
        break;

    // ➕ THÊM
    case "POST":
        $data = json_decode(file_get_contents("php://input"), true);

        if(!$data){
            echo json_encode(["status"=>false,"message"=>"Dữ liệu không hợp lệ"]);
            exit;
        }

        if(empty($data['theater_name'])){
            echo json_encode(["status"=>false,"message"=>"Tên rạp không được trống"]);
            exit;
        }

        $result = $theater->create($data);

        echo json_encode([
            "status"=>$result,
            "message"=>$result ? "Thêm rạp thành công 🎉" : "Thêm thất bại ❌"
        ]);
        break;

    // ✏️ SỬA
    case "PUT":
        $data = json_decode(file_get_contents("php://input"), true);

        if(!isset($data['theater_id'])){
            echo json_encode(["status"=>false,"message"=>"Thiếu ID"]);
            exit;
        }

        if(empty($data['theater_name'])){
            echo json_encode(["status"=>false,"message"=>"Tên rạp không được trống"]);
            exit;
        }

        $result = $theater->update($data);

        echo json_encode([
            "status"=>$result,
            "message"=>$result ? "Cập nhật thành công 🎉" : "Cập nhật thất bại ❌"
        ]);
        break;

    // ❌ XOÁ
    case "DELETE":
        $data = json_decode(file_get_contents("php://input"), true);

        if(!isset($data['theater_id'])){
            echo json_encode(["status"=>false,"message"=>"Thiếu ID để xóa"]);
            exit;
        }

        $result = $theater->delete($data['theater_id']);

        echo json_encode([
            "status"=>$result,
            "message"=>$result ? "Xóa thành công" : "Xóa thất bại"
        ]);
        break;
}
?>