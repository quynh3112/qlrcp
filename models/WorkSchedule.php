<?php
include "../config/db.php";
class WorkSchedule{
    public function create($user_id,$workdate,$shift,$start,$end,$note){
        global $conn;
        $sql="Insert Into work_schedule (user_id,work_date,shift,start_time,end_time,note) VALUES ('$user_id','$workdate','$shift','$start','$end','$note')";
        return $conn->query($sql);

    }
    public function delete($id){
        global $conn;
        $sql="DELETE FROM work_schesule WHERE schedule_id= '$id' ";
        return $conn->query($sql);


    }
    public function findById($id){
        global $conn;
        $sql="SELECT 1 FROM work_schedule WHERE schedule_id=' $id'";
        return $conn->query($sql);
    }
    public function edit($id,$user_id,$workdate,$shift,$start,$end,$note){
        global $conn;
        $sql="UPDATE work_schedule SET user_id='$user_id', work_date='$workdate',shift='$shift',start_time='$start',end_time='$end', note=$note";
        return $conn->query($sql);
    }
    public function findByUserId($user_id){
        global $conn;
        $sql="SELECT * From work_schedule WHERE user_id='$user_id'";
        return $conn->query($sql);

    }
}
?>