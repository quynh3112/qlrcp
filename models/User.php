<?php
include "../config/db.php";
class User{
   public function create($username, $password, $email, $phone, $role) {
    global $conn;

    if (empty($role)) {
        $role = "customer";
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO Users (username, password, email, phone, role) 
            VALUES ('$username', '$hash', '$email', '$phone', '$role')";

    return $conn->query($sql);
}
    public function delete($id){
        global $conn;
        $sql="DELETE FROM Users WHERE user_id= '$id' ";
        return $conn->query($sql);
    }
    public function check($id){
        global $conn;
        $sql="SELECT 1 From User WHERE user_id='$id'";
        return $conn->query($sql);

    }
}

?>