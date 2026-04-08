<?php
header("Content-Type: application/json");
include "../config/db.php";
include "../models/movies.php";
$movie = new Movie($conn);
$method = $_SERVER['REQUEST_METHOD'];
switch($method){
    case "GET":
        $result = $movie->getAll();
        $movies = [];
        while($row = $result->fetch_assoc()){
            $movies[] = $row;
        }
        echo json_encode([
            "status" => true,
            "data" => $movies
        ]);
        break;
    case "POST":
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            echo json_encode([
                "status" => false,
                "message" => "Dữ liệu không hợp lệ!"
            ]);
            exit;
        }
        if (empty($data['title'])) {
            echo json_encode([
                "status" => false,
                "message" => "Tên phim không được để trống!"
            ]);
            exit;
        }
        if (!isset($data['duration']) || !is_numeric($data['duration']) || $data['duration'] <= 0) {
            echo json_encode([
                "status" => false,
                "message" => "Thời lượng phải là số > 0!"
            ]);
            exit;
        }
        $result = $movie->create($data);
        echo json_encode([
            "status" => $result,
            "message" => $result ? "Thêm phim thành công 🎉" : "Lỗi database ❌"
        ]);
        break;
    case "PUT":
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            echo json_encode([
                "status" => false,
                "message" => "Dữ liệu không hợp lệ!"
            ]);
            exit;
        }
        if (empty($data['title'])) {
            echo json_encode([
                "status" => false,
                "message" => "Tên phim không được để trống!"
            ]);
            exit;
        }
        if (!isset($data['movie_id'])) {
            echo json_encode([
                "status" => false,
                "message" => "Thiếu ID phim!"
            ]);
            exit;
        }
        $result = $movie->update($data);
        echo json_encode([
            "status" => $result,
            "message" => $result ? "Cập nhật thành công " : "Cập nhật thất bại ❌"
        ]);
        break;
    case "DELETE":
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['movie_id'])) {
            echo json_encode([
                "status" => false,
                "message" => "Thiếu ID để xóa!"
            ]);
            exit;
        }
        $result = $movie->delete($data['movie_id']);
        echo json_encode([
            "status" => $result,
            "message" => $result ? "Xóa thành công " : "Xóa thất bại "
        ]);
        break;
}
?>