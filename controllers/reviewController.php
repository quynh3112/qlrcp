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

            if ($review->create($rating, $comment)) {
                echo json_encode([
                    "status" => true,
                    "message" => "Bình luận thành công!"
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

            if ($review->update($rating, $comment)) {
                echo json_encode([
                    "status" => true,
                    "message" => "Cập nhật bình luận thành công!"
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
            }

            break;

        case "GET":
            $list = [];
            $result = $review -> getall();
            
            if ($result -> num_rows > 0) {
                while ($row$row = $result -> fetch_assoc()) {
                    $list[] = [
                        $rating = $row['rating'],
                        $comment = $row['comment']
                    ]     
                }
                echo json_encode [(
                    "status" => true,
                    $list
                )];
            }
            else {
                echo json_encode ([
                    "status" => false,
                    "message" => "Chưa có bình luận"
                ]);
            }
    }
?>