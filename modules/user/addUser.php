<?php
header("Content-Type: application/Json");
include "connect.php";
$data=json_decode(file_get_contents("php://input"),true);
$username=$data['username'];
$password=$data['password'];
$email=$data['email'];
$phone=$data['phone'];
$role=$data['role'];
$sql="INSERT INTO FROM Users (username,password,email,phone,role) Values('$username','$password','$email','$phone','$role')";
$find="SELECT 1 FROM Users WHERE username='$username'";
$result=$conn->query($find);
if(empty($username)||empty($password)||
empty($email)||empty($phone)){
    echo json_encode([
        "status"=>false,
        "message"=>"Không được bỏ trống"
        
    ]);
}
if($result->num_rows>0){
    echo json_encode(
        [
            "status"=>false,
            "message"=>"username đã tồn tại!"
        ]
    );
    exit;
}
if($conn->query($sql)){
    echo json_encode(
    [
        "status"=>TRUE,
        "message"=>"Đăng kí thành công !",
        "user"=>[
            "username"=>$username,
            "email"=>$email,
            "phone"=>$phone
        ]

    ]

    );
}
else{
    echo json_encode([
        "status"=>false,
        "message"=>"Đăng kí thất bại!"
    ]);
}




?>