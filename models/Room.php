<?php
include "../config/db.php";
include "Seats.php";

class Room {
    public function create($theater_name, $total_seats, $cinema_id, $type) {
        global $conn;

        $sql = "INSERT INTO Rooms (theater_name, total_seats, cinema_id, type) 
                VALUES ('$theater_name', '$total_seats', '$cinema_id', '$type')";

        if ($conn->query($sql)) {

            $room_id = $conn->insert_id;

            $seats = new Seats();
            $seats->generateSeat( $room_id, $total_seats);

            return [
                "status" => true,
                "message" => "Tạo phòng + ghế thành công",
                "room_id" => $room_id
            ];
        } else {
            return [
                "status" => false,
                "message" => "Lỗi tạo phòng: " . $conn->error
            ];
        }
    }
    public function check($cinema_id,$name){
        global $conn;
        $sql="SELECT 1 FROM Rooms WHERE cinema_id='$cinema_id' and theater_name='$name'";
        return $conn->query($sql);
    }

   public function delete($room_id){
    global $conn;
       $seat=new Seats();
       $seat->delete($room_id);

      
        $conn->query("DELETE FROM rooms WHERE theater_id = '$room_id'");

        $conn->commit();

        return [
            "status" => true,
            "message" => "Xóa phòng + ghế thành công"
        ];
    
}
    public function find($id){
        global $conn;
        $sql="SELECT * From Rooms Where theater_id='$id'";
        return $conn->query($sql);
    }
    public function findAll(){
        global $conn;
        return $conn->query("SELECT * FROM Rooms");

    }

}
?>