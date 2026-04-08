<?php
    header("Content-Type: application/json");

    $data = json_decode(file_get_contents("php://input", true));

    include "../models/Reviews.php";

    $review = new Reviews();

    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method) {
        case "POST":
            $rating = $data["rating"] ?? null;
            $comment = $data["comment"] ?? null;

            if (!$rating) {
                echo json_encode([
                    "status" => false,
                    "message" => "Vui lòng đánh giá sao!"
                ]);
                exit;
            }

            if (!$comment) {
                echo json_encode([
                    "status" => false,
                    "message" => "Vui lòng viết bình luận!"
                ]);
                exit;
            }

            if ($review->create($data["movie_id"], $data["user_id"], $rating, $comment, date('Y-m-d H:i:s'))) {
                echo json_encode([
                    "status" => true,
                    "message" => "Bình luận thành công!"
                ]);
            } else {
                echo json_encode([
                    "status" => false,
                    "message" => "Bình luận thất bại!"
                ]);
            }

            break;
        
        case "PUT":
            $id = $data["id"] ?? null;
            $rating = $data["rating"] ?? null;
            $comment = $data["comment"] ?? null;

            if (!$rating) {
                echo json_encode([
                    "status" => false,
                    "message" => "Vui lòng đánh giá sao!"
                ]);
                exit;
            }

            if (!$comment) {
                echo json_encode([
                    "status" => false,
                    "message" => "Vui lòng viết bình luận!"
                ]);
                exit;
            }

            if ($review->update($id, $rating, $comment)) {
                echo json_encode([
                    "status" => true,
                    "message" => "Cập nhật bình luận thành công!"
                ]);
            } else {
                echo json_encode([
                    "status" => false,
                    "message" => "Cập nhật bình luận thất bại!"
                ]);
            }

            break;

        case "DELETE":
            $id = $data["id"] ?? null;

            if ($review->delete($id)) {
                echo json_encode([
                    "status" => true,
                    "message" => "Xóa bình luận thành công!"
                ]);
            } else {
                echo json_encode([
                    "status" => false,
                    "message" => "Xóa bình luận thất bại!"
                ]);
            }

            break;

        case "GET":
            $id = $_GET['id'] ?? null;
            $list = [];
            $result = $review -> getall($id);
            
            if ($result && $result -> num_rows > 0) {
                while ($row = $result -> fetch_assoc()) {
                    $list[] = [
                        "rating" => $row['rating'],
                        "comment" => $row['comment'],
                        "review_date" => $row['review_date']
                    ] ;    
                }
                echo json_encode ([
                    "status" => true,
                    "data" => $list
                ]);
            }
            else {
                echo json_encode ([
                    "status" => false,
                    "message" => "Chưa có bình luận nào!"
                ]);
            }
    }
?>