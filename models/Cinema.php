<?php
include "../config/db.php";
class Cinema{
    public function create($name,$location){
        global $conn;
        $sql="INSERT INTO Cinemas (name,location) VALUES ('$name','$location')";
        return $conn->query($sql);

    }
    public function delete($id){
        global $conn;
        $sql="DELETE FROM Cinemas WHERE cinema_id= '$id'";
        return $sql->query($sql);
    }
    public function edit($id,$name,$location){
        global $conn;
        $sql="UPDATE Cinemas Set name='$name', location='$location' Where cinema_id='$id'";
        return $conn->query($sql);
      
    }
    public function findAll(){
        global $conn;
        $sql="SELECT * FROM Cinemas";
        return $conn->query($sql);
    }
    public function find($id){
        global $conn;
        $sql="Select * FROM Cinemas WHERE cinema_id='$id'";
        return $conn->query($sql);

    }
    public function check($name){
        global $conn;
        $sql="SELECT 1 FROM Cinema WHERE name='$name'";
        return $conn->query($sql);

    }
   
}
?>