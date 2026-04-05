
<?php
$host="localhost";
$user="root";
$password="";
$db="mntheatre";
$conn=new mysqli($host,$user,$password,$db);
if($conn->connect_error){
    die("Kết nối thất bại");

}

?>
