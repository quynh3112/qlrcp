<?php
header ("Content-Type: application/json");
include "../config/db.php";
include "../models/foodModels.php";

$db = $conn;
$foodItem = new FoodItem($db);
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval ($_GET['id']);
            $result = $foodItem->getById($id);
            $row = ($result) ? $result->fetch_assoc() : null;
            echo json_encode (["success" => true, "data" => $row]);
        } else {
            $result = $foodItem->getAll();
            $items = [];
            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }
            echo json_encode (["success" => true, "data" => $items]);
        }
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (empty($data['name']) || empty($data['price'])) {
            echo json_encode(["success" => false, "message" => "Thiếu name hoặc price"]);
            break;
        }
        if ($foodItem->create($data)) {
            echo json_encode (["success" => true, "message" => "Thêm món ăn thành công."]);
        } else {
            echo json_encode (["success" => false, "message" => "Lỗi khi thêm món ăn."]);
        }
        break;
    case 'PUT':
        $id = intval($_GET['id']);
        $data = json_decode(file_get_contents("php://input"), true);
       
        if ($foodItem->update($id, $data)) {
            echo json_encode (["success" => true, "message" => "Cập nhật món ăn thành công."]);
        } else {
            echo json_encode (["success" => false, "message" => "Lỗi khi cập nhật."]);
        }
        break;
    case 'DELETE':
        $id = intval ($_GET['id']);
        if ($foodItem->delete($id)) {
            echo json_encode (["success" => true, "message" => "Xóa món ăn thành công."]);
        } else {
            echo json_encode (["success" => false, "message" => "Xoá thất bại."]);
        }
        break;
} 
?>