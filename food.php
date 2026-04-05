<?php
header ("Content-Type: application/json; charset=UTF-8");
include 'db.php';
$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
        $id = intval ($_GET['id']);
        $sql = "SELECT * FROM fooditems WHERE food_id = $id";
        $result = $conn->query($sql);
        echo json_encode (["success" => true, "data" => $result->fetch_assoc()]);
        } else {
            $sql = "SELECT * FROM fooditems ORDER BY food_id ASC";
            $result = $conn->query($sql);
            $items = array();
            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }
            echo json_encode (["success" => true, "data" => $items]);
        }
        break;
    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        $name = $input['name'];
        $price = $input['price'];

        $sql = "INSERT INTO fooditems (name, price) VALUES ('$name', '$price')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode (["success" => true, "message" => "Thêm món ăn thành công"]);
        } else {
            echo json_encode (["success" => false, "message" => "Lỗi: " . $conn->error]);
        }
        break;
    case 'DELETE':
        $id = intval ($_GET['id']);
        $sql = "DELETE FROM fooditems WHERE food_id = $id";
        if ($conn->query($sql) === TRUE) {
            echo json_encode (["success" => true, "message" => "Đã xoá món ăn"]);
        }
        break;      
}
$conn->close();
?>