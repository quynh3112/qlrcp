<?php
include "../models/Ticket.php";
$method=$_SERVER['REQUEST_METHOD'];
$ticket=new Tickets();
switch($method){
    case 'POST':
        $data=json_decode(file_get_contents("php://input"),true);
        $ticketID=$data['ticket_id'];
        $showtimeId=$data['showtime_id'];
        $seatID=$data['seat_id'];
        $userID=$data['user_id'];
        if($ticket->create($ticketID,$showtimeId,$seatID,$userID)){
            echo json_encode(["message"=>"Ticket created successfully"]);
        }else{
            echo json_encode(["message"=>"Failed to create ticket"]);
        }
        break;
    case 'PUT':
        $data=json_decode(file_get_contents("php://input"),true);
        $ticketID=$data['ticket_id'];
        $showtimeId=$data['showtime_id'];
        $seatID=$data['seat_id'];
        $userID=$data['user_id'];
        if($ticket->update($ticketID,$showtimeId,$seatID,$userID)){
            echo json_encode(["message"=>"Ticket updated successfully"]);
        }else{
            echo json_encode(["message"=>"Failed to update ticket"]);
        }
        break;
    case 'DELETE':
        $data=json_decode(file_get_contents("php://input"),true);
        $ticketID=$data['ticket_id'];
        
        if($ticket->delete($ticketID)){
            echo json_encode(["message"=>"Ticket deleted successfully"]);
        }else{
            echo json_encode(["message"=>"Failed to delete ticket"]);
        }
        break;
    case "GET":
        $userid=$_GET['user_id'];
        $list = [];
            $result = $ticket -> getall($userid);
            
            if ($result && $result -> num_rows > 0) {
                while ($row = $result -> fetch_assoc()) {
                    $list[] = [
                        "ticket_id" => $row['ticket_id'],
                        "showtime_id" => $row['showtime_id'],
                        "seat_id" => $row['seat_id'],
                        "user_id" => $row['user_id'],
                        "booking_time" => $row['booking_time']
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
                    "message" => "Không tìm thấy vé nào!"
                ]);
            }
}
?>