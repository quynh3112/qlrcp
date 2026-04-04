<?php
header("Content-Type: application/json");
include "../config/db.php";

$method = $_SERVER['REQUEST_METHOD'];

switch($method){

    // LẤY DANH SÁCH PHIM
    case "GET":
        $sql = "SELECT * FROM movies";
        $result = $conn->query($sql);

        $movies = [];
        while($row = $result->fetch_assoc()){
            $movies[] = $row;
        }

        echo json_encode([
            "status" => true,
            "data" => $movies
        ]);
        break;

    //THÊM PHIM
    case "POST":
        $data = json_decode(file_get_contents("php://input"), true);

        $stmt = $conn->prepare("INSERT INTO movies(title, genre, duration, release_date, director, language, rating, description, poster_url, trailer_url)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param(
            "ssisssdsss",
            $data['title'],
            $data['genre'],
            $data['duration'],
            $data['release_date'],
            $data['director'],
            $data['language'],
            $data['rating'],
            $data['description'],
            $data['poster_url'],
            $data['trailer_url']
        );

        $result = $stmt->execute();

        echo json_encode([
            "status" => $result,
            "message" => $result ? "Thêm phim thành công" : "Thêm thất bại"
        ]);
        break;

    //PUT - CẬP NHẬT PHIM
    case "PUT":
        $data = json_decode(file_get_contents("php://input"), true);

        $stmt = $conn->prepare("UPDATE movies SET
            title=?, genre=?, duration=?, release_date=?, director=?, language=?, rating=?, description=?, poster_url=?, trailer_url=?
            WHERE movie_id=?");

        $stmt->bind_param(
            "ssisssdsssi",
            $data['title'],
            $data['genre'],
            $data['duration'],
            $data['release_date'],
            $data['director'],
            $data['language'],
            $data['rating'],
            $data['description'],
            $data['poster_url'],
            $data['trailer_url'],
            $data['movie_id']
        );

        $result = $stmt->execute();

        echo json_encode([
            "status" => $result,
            "message" => $result ? "Cập nhật thành công" : "Cập nhật thất bại"
        ]);
        break;

    //DELETE - XOÁ PHIM
    case "DELETE":
        $data = json_decode(file_get_contents("php://input"), true);

        $stmt = $conn->prepare("DELETE FROM movies WHERE movie_id=?");
        $stmt->bind_param("i", $data['movie_id']);

        $result = $stmt->execute();

        echo json_encode([
            "status" => $result,
            "message" => $result ? "Xóa thành công" : "Xóa thất bại"
        ]);
        break;
}
?>