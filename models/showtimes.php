<?php
class Showtime {
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    //  LẤY TẤT CẢ LỊCH CHIẾU 
    public function getAll(){
        $sql = "SELECT s.*, m.title, t.theater_name
                FROM showtimes s
                JOIN movies m ON s.movie_id = m.movie_id
                JOIN theaters t ON s.theater_id = t.theater_id";

        return $this->conn->query($sql);
    }

    //  LẤY THEO ID
    public function getById($id){
        $stmt = $this->conn->prepare("
            SELECT s.*, m.title, t.theater_name
            FROM showtimes s
            JOIN movies m ON s.movie_id = m.movie_id
            JOIN theaters t ON s.theater_id = t.theater_id
            WHERE s.showtime_id=?
        ");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // LỌC THEO PHIM
    public function getByMovie($movie_id){
        $stmt = $this->conn->prepare("
            SELECT * FROM showtimes
            WHERE movie_id=?
        ");
        $stmt->bind_param("i", $movie_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // THÊM LỊCH CHIẾU
    public function create($data){
        $stmt = $this->conn->prepare("
            INSERT INTO showtimes(movie_id, theater_id, show_date, start_time, price)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "iissd",
            $data['movie_id'],
            $data['theater_id'],
            $data['show_date'],
            $data['start_time'],
            $data['price']
        );

        return $stmt->execute();
    }

    //CẬP NHẬT
    public function update($data){
        $stmt = $this->conn->prepare("
            UPDATE showtimes SET
            movie_id=?,
            theater_id=?,
            show_date=?,
            start_time=?,
            price=?
            WHERE showtime_id=?
        ");

        $stmt->bind_param(
            "iissdi",
            $data['movie_id'],
            $data['theater_id'],
            $data['show_date'],
            $data['start_time'],
            $data['price'],
            $data['showtime_id']
        );

        return $stmt->execute();
    }

    //XOÁ
    public function delete($id){
        $stmt = $this->conn->prepare("
            DELETE FROM showtimes WHERE showtime_id=?
        ");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>