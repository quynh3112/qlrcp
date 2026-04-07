<?php
include_once "../models/Ticket.php";
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

}
?>