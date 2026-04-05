<?php
header ("Content-Type: application/json");
include "../config/db.php";
include "../models/orderModels.php";

$db = $conn;
$order = new OrderModel($db);
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
     case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $result = $order->getById($id);
            $row = $result ? $result->fetch_assoc() : null;
            echo json_encode(["success" => true, "data" => $row]);
        } else {
            $result = $order->getAll();
            $orders = [];
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
            echo json_encode(["success" => true, "data" => $orders]);
        }
        break;
        case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (empty($data['user_id'])) {
            echo json_encode(["success" => false, "message" => "Thiếu user_id."]);
            break;
        }
        if (empty($data['items'])) {
            echo json_encode(["success" => false, "message" => "Chưa chọn món ăn nào."]);
            break;
        }
        $order_id = $order->create($data); 
        if ($order_id) {
            echo json_encode(["success" => true, "message" => "Đặt hàng thành công.", "order_id" => $order_id]);
        } else {
            echo json_encode(["success" => false, "message" => "Lỗi đặt đơn."]);
        }
        break;
        case 'DELETE':
        $id = intval($_GET['id']);
        if ($order->delete($id)) {
            echo json_encode(["success" => true, "message" => "Đã huỷ đơn hàng."]);
        } else {
            echo json_encode(["success" => false, "message" => "Lỗi khi huỷ."]);
        }
        break;
}
?>
 