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

    public function update($id, $username, $password, $email, $phone, $role) {
        global $conn;
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE Users SET username='$username', password='$hash', email='$email', phone='$phone', role='$role' 
                WHERE user_id='$id'";
        return $conn->query($sql);
    }
    
    public function check($id){
        global $conn;
        $sql="SELECT 1 From Users WHERE user_id='$id'";
        return $conn->query($sql);
    }

    public function checkUsername($username) {
        global $conn;
        $sql = "SELECT 1 FROM Users WHERE username='$username'";
        return $conn->query($sql);
    }
}
?>