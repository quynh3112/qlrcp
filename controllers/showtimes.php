<?php
header("Content-Type: application/json");
include "../config/db.php";
include "../models/showtimes.php";
$showtime = new Showtime($conn);
$method = $_SERVER['REQUEST_METHOD'];
switch($method){
    case "GET":
        $result = $showtime->getAll();
        $list = [];
        while($row = $result->fetch_assoc()){
            $list[] = $row;
        }
        echo json_encode([
            "status"=>true,
            "data"=>$list
        ]);
        break;
    case "POST":
        $data = json_decode(file_get_contents("php://input"), true);
        if(!$data){
            echo json_encode(["status"=>false,"message"=>"Dữ liệu không hợp lệ"]);
            exit;
        }
        if(empty($data['movie_id']) || empty($data['theater_id'])){
            echo json_encode(["status"=>false,"message"=>"Thiếu movie hoặc rạp"]);
            exit;
        }
        if(empty($data['show_date']) || empty($data['start_time'])){
            echo json_encode(["status"=>false,"message"=>"Thiếu ngày hoặc giờ"]);
            exit;
        }
        if(!is_numeric($data['price']) || $data['price'] <= 0){
            echo json_encode(["status"=>false,"message"=>"Giá phải > 0"]);
            exit;
        }
        $result = $showtime->create($data);
        echo json_encode([
            "status"=>$result,
            "message"=>$result?"Thêm thành công":"Lỗi DB"
        ]);
        break;
    case "PUT":
        $data = json_decode(file_get_contents("php://input"), true);
        if(!isset($data['showtime_id'])){
            echo json_encode(["status"=>false,"message"=>"Thiếu ID"]);
            exit;
        }
        $result = $showtime->update($data);
        echo json_encode([
            "status"=>$result,
            "message"=>$result?"Cập nhật OK":"Cập nhật lỗi"
        ]);
        break;
    case "DELETE":
        $data = json_decode(file_get_contents("php://input"), true);
        if(!isset($data['showtime_id'])){
            echo json_encode(["status"=>false,"message"=>"Thiếu ID để xóa"]);
            exit;
        }
        $result = $showtime->delete($data['showtime_id']);

        echo json_encode([
            "status"=>$result,
            "message"=>$result?"Xóa OK":"Xóa lỗi"
        ]);
        break;
}
?>