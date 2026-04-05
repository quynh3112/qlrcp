<?php
header('Content-Type: application/json');

include '../config/db.php';
include '../models/WorkSchedule.php';

$method = $_SERVER['REQUEST_METHOD'];
$work_schedule = new WorkSchedule();

switch ($method){
    case "POST":
        $data = json_decode(file_get_contents("php://input"), true);

        $user_id = $data["user_id"];
        $work_date = $data["work_date"];
        $shift = $data["shift"];
        $start_time = $data["start_time"];
        $end_time = $data["end_time"];
        $note = $data["note"] ?? "";
        $today = date("Y-m-d");
        if($work_date<$today){
            echo json_encode([
                "status"=>false,
                "message"=>"Ngày nhập không được nhỏ hơn ngày hiện tại!"
            ]);
            exit;
        }




        if(!$user_id || !$work_date || !$shift || !$start_time || !$end_time){
            echo json_encode([
                "status"=>false,
                "message"=>"Không được bỏ trống!"
            ]);
            exit;
        }

        $result = $work_schedule->create($user_id,$work_date,$shift,$start_time,$end_time,$note);

        echo json_encode([
            "status"=>$result,
            "message"=>$result ? "Thành Công!" : "Thất Bại!"
        ]);
        break;
    case "GET":
        $user_id=$_GET["user_id"];
        $result=$work_schedule->findByUserId($user_id);
        $data=[];
        if($result->num_rows>0){
            while ($row=$result->fetch_assoc()){
                $data[]=$row;
            }
        }
        echo json_encode($data);
        break;
        
}
?>