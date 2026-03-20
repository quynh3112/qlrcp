<?php
header("Content-Type: application/json");

include "../models/User.php";

$user = new User();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case "POST":
        $data = json_decode(file_get_contents("php://input"), true);

        $username = $data["username"] ?? null;
        $password = $data["password"] ?? null;
        $email    = $data["email"] ?? null;
        $phone    = $data["phone"] ?? null;
        $role     = $data["role"] ?? null;

        if (!$username || !$password) {
            echo json_encode([
                "status" => false,
                "message" => "Thiếu username hoặc password"
            ]);
            exit;
        }

        $result = $user->create($username, $password, $email, $phone, $role);

        echo json_encode([
            "status" => $result,
            "message" => $result ? "Tạo user thành công" : "Tạo thất bại"
        ]);
        break;

    case "DELETE":
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data["id"] ?? null;

        if (!$id) {
            echo json_encode([
                "status" => false,
                "message" => "Thiếu ID"
            ]);
            exit;
        }

        $result = $user->delete($id);

        echo json_encode([
            "status" => $result,
            "message" => $result ? "Xóa thành công" : "Xóa thất bại"
        ]);
        break;

    default:
        echo json_encode([
            "status" => false,
            "message" => "Method không hợp lệ"
        ]);
}
?>