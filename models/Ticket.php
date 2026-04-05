<?php
header('Content-Type: application/json');
include "../config/db.php";
class Tickets {
   
    private $table_name = "tickets";

     public function create($ticketID,$showtimeId,$seatID,$userID) {
        global $conn;


        $query="INSERT INTO " . $this->table_name ."(ticket_id,showtime_id,seat_id,user_id, booking_time) VALUES ('$ticketID','$showtimeId','$seatID','$userID', NOW())";
        return $conn->query($query);
      
       
    }

   public function update($ticketID,$showtimeId,$seatID,$userID) {
    global $conn;
    $query="UPDATE " . $this->table_name ." SET showtime_id='$showtimeId', seat_id='$seatID', user_id='$userID' WHERE ticket_id='$ticketID'";
    return $conn->query($query);


   }
   public function delete($ticketID) {
    global $conn;
    $query="DELETE FROM " . $this->table_name ." WHERE ticket_id='$ticketID'";
    return $conn->query($query);


    }
}