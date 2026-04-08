<?php
header("Content-Type: application/json");

$data = json_decode(file_get_contents("php://input", true));

include "../models/User.php";

$user = new User();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case "POST":
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

        if ($user->checkUsername($username)->num_rows > 0) {
            echo json_encode([
                "status" => false,
                "message" => "Username đã tồn tại"
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
        $id = $data["id"] ?? null;

        if (!$id) {
            echo json_encode([
                "status" => false,
                "message" => "Thiếu ID"
            ]);
            exit;
        }
        
        if ($user->check($id)->num_rows == 0) {
            echo json_encode([
                "status" => false,
                "message" => "User không tồn tại, không thể xóa"
            ]);
            exit;
        }

        $result = $user->delete($id);

        echo json_encode([
            "status" => $result,
            "message" => $result ? "Xóa thành công" : "Xóa thất bại"
        ]);
        break;
    
    case "PUT":
        $id = $data["id"] ?? null;
        if (!$id) {
            echo json_encode([
                "status" => false,
                "message" => "Thiếu ID"
            ]);
            exit;
        }

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

        if($user->update($id, $username, $password, $email, $phone, $role)){
            echo json_encode([
                "status" => true,
                "message" => "Cập nhật thành công"
            ]);
        }else{
            echo json_encode([
                "status" => false,
                "message" => "Cập nhật thất bại"
            ]);
        }
        break;
}
?>