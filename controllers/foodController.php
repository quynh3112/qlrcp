<?php
header ("Content-Type: application/json");
include "../config/db.php";
include "../models/foodModels.php";

$foodItem = new FoodItem($conn);
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $result = $foodItem->getById(intval($_GET['id']));
            echo json_encode(["success" => true, "data" => $result->fetch_assoc()]);
        } else {
            $result = $foodItem->getAll();
            echo json_encode(["success" => true, "data" => $result->fetch_all(MYSQLI_ASSOC)]);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if ($foodItem->create($data)) 
            echo json_encode(["success" => true, "message" => "Thêm món thành công."]);
        else 
            echo json_encode(["success" => false, "message" => "Lỗi khi thêm."]);
        break;

    case 'PUT':
        
        $data = json_decode(file_get_contents("php://input"), true);
       
        $id = intval($data['food_id'] ?? $_GET['id'] ?? 0);
        
        if ($id > 0 && $foodItem->update($id, $data)) {
            echo json_encode(["success" => true, "message" => "Cập nhật món thành công."]);
        } else {
            echo json_encode(["success" => false, "message" => "Không tìm thấy ID hoặc lỗi cập nhật."]);
        }
        break;

    case 'DELETE':
        $id = intval($_GET['id'] ?? 0);
        if ($id > 0 && $foodItem->delete($id)) {
            echo json_encode(["success" => true, "message" => "Xóa món ăn thành công."]);
        } else {
            echo json_encode(["success" => false, "message" => "Xóa thất bại (thiếu ID)."]);
        }
        break;
} 
?>