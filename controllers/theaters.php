<?php
require_once "../models/Theater.php";

class TheaterController {
    private $theater;

    public function __construct($db){
        $this->theater = new Theater($db);
    }

    // GET ALL
    public function getAll(){
        $result = $this->theater->getAll();
        $data = [];

        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }

        echo json_encode([
            "status" => true,
            "data" => $data
        ]);
    }

    // GET BY ID
    public function getById($id){
        $result = $this->theater->getById($id);
        echo json_encode($result->fetch_assoc());
    }

    // CREATE
    public function create(){
        $data = json_decode(file_get_contents("php://input"), true);

        $result = $this->theater->create($data);

        echo json_encode([
            "status" => $result,
            "message" => $result ? "Thêm phòng thành công" : "Thất bại"
        ]);
    }

    // UPDATE
    public function update(){
        $data = json_decode(file_get_contents("php://input"), true);

        $result = $this->theater->update($data);

        echo json_encode([
            "status" => $result,
            "message" => $result ? "Cập nhật thành công" : "Thất bại"
        ]);
    }

    // DELETE
    public function delete(){
        $data = json_decode(file_get_contents("php://input"), true);

        $result = $this->theater->delete($data['theater_id']);

        echo json_encode([
            "status" => $result,
            "message" => $result ? "Xóa thành công" : "Thất bại"
        ]);
    }
}
?>