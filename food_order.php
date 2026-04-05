<?php
header ("Content-Type: text/html; charset=UTF-8");
include 'db.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $sql = "SELECT fo.order_id, fo.order_time, u.username
                FROM foodorders fo
                JOIN users u ON fo.user_id = u.user_id
                ORDER BY fo.order_id DESC";
        $result = $conn->query($sql);
        $orders = array();
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        echo json_encode (["success" => true, "data" => $orders]);
        break;
    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        $user_id = $input['user_id'];
        $time = date('Y-m-d H:i:s');

        $sql = "INSERT INTO foodorders (user_id, order_time) VALUES ('$user_id', '$time')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode (["success" => true, "message" => "Đặt hàng thành công!", "order_id" => $conn->insert_id]);
        } else {
            echo json_encode (["success" => false, "message" => "Lỗi đặt đơn"]);
        }
        break;
    case "DELETE":
        $id = intval ($_GET['id']);
        $sql = "DELETE FROM foodorders WHERE order_id = $id";
        if ($conn->query($sql) === TRUE) {
            echo json_encode (["success" => true, "message" => "Đã huỷ đơn hàng"]);
        }
        break;
}
        $conn->close();
?>