<?php
header("Content-Type: application/json");
include "../config/db.php";

$method = $_SERVER['REQUEST_METHOD'];

switch($method){

    //LẤY LỊCH CHIẾU
    case "GET":
        $sql = "SELECT s.*, m.title, t.theater_name
                FROM showtimes s
                JOIN movies m ON s.movie_id = m.movie_id
                JOIN theaters t ON s.theater_id = t.theater_id";

        $result = $conn->query($sql);

        $list = [];
        while($row = $result->fetch_assoc()){
            $list[] = $row;
        }

        echo json_encode($list);
        break;

    //THÊM LỊCH CHIẾU
    case "POST":
        $data = json_decode(file_get_contents("php://input"), true);

        $movie_id = $data['movie_id'];
        $theater_id = $data['theater_id'];
        $show_date = $data['show_date'];
        $start_time = $data['start_time'];
        $price = $data['price'];

        $sql = "INSERT INTO showtimes(movie_id, theater_id, show_date, start_time, price)
                VALUES('$movie_id','$theater_id','$show_date','$start_time','$price')";

        $result = $conn->query($sql);

        echo json_encode([
            "status"=>$result,
            "message"=>$result ? "Thêm lịch chiếu thành công" : "Thêm thất bại"
        ]);
        break;

    //SỬA
    case "PUT":
        $data = json_decode(file_get_contents("php://input"), true);

        $id = $data['showtime_id'];

        $sql = "UPDATE showtimes SET
                movie_id='{$data['movie_id']}',
                theater_id='{$data['theater_id']}',
                show_date='{$data['show_date']}',
                start_time='{$data['start_time']}',
                price='{$data['price']}'
                WHERE showtime_id='$id'";

        $result = $conn->query($sql);

        echo json_encode([
            "status"=>$result,
            "message"=>$result ? "Sửa thành công" : "Sửa thất bại"
        ]);
        break;

    //XÓA
    case "DELETE":
        $data = json_decode(file_get_contents("php://input"), true);

        $id = $data['showtime_id'];

        $sql = "DELSETE FROM showtimes WHERE showtime_id='$id'";
        $result = $conn->query($sql);

        echo json_encode([
            "status"=>$result,
            "message"=>$result ? "Xóa thành công" : "Xóa thất bại"
        ]);
        break;
}
?>