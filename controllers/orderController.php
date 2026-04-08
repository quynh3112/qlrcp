<?php
header ("Content-Type: application/json");
include "../config/db.php";
include "../models/orderModels.php";

$order = new OrderModel($conn);
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
     case 'GET':
        if (isset($_GET['id'])) {
            $result = $order->getById(intval($_GET['id']));
            echo json_encode(["success" => true, "data" => $result->fetch_assoc()]);
        } else {
            $result = $order->getAll();
            echo json_encode(["success" => true, "data" => $result->fetch_all(MYSQLI_ASSOC)]);
        }
        break;
        case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (empty($data['user_id']) || empty($data['items'])) {
            echo json_encode(["success" => false, "message" => "Thiếu dữ liệu đơn hàng"]);
            break;
        }
        $order_id = $order->create($data);
        if ($order_id) echo json_encode(["success" => true, "order_id" => $order_id]);
        else echo json_encode(["success" => false, "message" => "Lỗi tạo đơn hàng."]);
        break;
        case 'DELETE':
        if ($order->delete(intval($_GET['id']))) 
            echo json_encode(["success" => true, "message" => "Đã huỷ"]);
        else echo json_encode(["success" => false, "message" => "Lỗi huỷ"]);
        break;
}
?>
 