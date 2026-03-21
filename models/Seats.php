<?php
include "../config/db.php";

class Seats {
    public function generateSeat($room_id, $total_seat) {
        global $conn;

        $rows = min(10, ceil($total_seat / 10));
        $col = ceil($total_seat / $rows);

        $count = 0;

        for ($i = 0; $i < $rows; $i++) {
            for ($j = 1; $j <= $col; $j++) {

                if ($count >= $total_seat) break;

                $seat_number = chr(65 + $i) . $j;

                if ($i == 0) {
                    $seat_type = 'VIP';
                    $price = 10000;
                } elseif ($j >= $col - 1) {
                    $seat_type = "couple";
                    $price = 20000;
                } else {
                    $seat_type = "normal";
                    $price = 0;
                }

                $sql = "INSERT INTO seats (theater_id, seat_number, seat_type, price) 
                        VALUES ('$room_id', '$seat_number', '$seat_type', '$price')";

                $conn->query($sql);

                $count++;
            }
        }
    }
    public function delete($room_id){
        global $conn;
        $sql = "DELETE FROM seats WHERE theater_id = '$room_id'"; 
        return $conn->query($sql);


    }
    public function findAll($id){
        global $conn;
        return $conn->query("SELECT * FROM seats WHERE theater_id= '$id'");

    }

}
?>